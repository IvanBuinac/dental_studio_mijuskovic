import glob, os, sys
import numpy as np, cv2
from PIL import Image, ImageOps

RAW = '/home/user/dental_studio_mijuskovic/assets/raw'
OUT = '/home/user/dental_studio_mijuskovic/site/assets/img'
DBG = sys.argv[1] if len(sys.argv) > 1 else None
os.makedirs(OUT, exist_ok=True)
log = []

def raw(prefix):
    return glob.glob(os.path.join(RAW, prefix + '*'))[0]

def load(prefix):
    return ImageOps.exif_transpose(Image.open(raw(prefix))).convert('RGB')

def save(im, name, maxw, src):
    if im.width > maxw:
        im = im.resize((maxw, round(im.height * maxw / im.width)), Image.LANCZOS)
    im.save(os.path.join(OUT, name), 'WEBP', quality=80, method=6)
    log.append((name, os.path.basename(raw(src)) if src else '-', im.size))
    return im

def crop_ratio(im, rw, rh, cx=None, cy=None, box=None):
    """Largest rw:rh crop inside box (default whole image), centred on cx,cy."""
    x0, y0, x1, y1 = box or (0, 0, im.width, im.height)
    W, H = x1 - x0, y1 - y0
    if W / H > rw / rh:
        h = H; w = round(H * rw / rh)
    else:
        w = W; h = round(W * rh / rw)
    cx = x0 + W / 2 if cx is None else cx
    cy = y0 + H / 2 if cy is None else cy
    l = int(min(max(cx - w / 2, x0), x1 - w)); t = int(min(max(cy - h / 2, y0), y1 - h))
    return im.crop((l, t, l + w, t + h))

def remove_logo(im, bbox):
    """Inpaint the dark 'Dental Studio Mijuskovic' watermark inside bbox."""
    a = np.asarray(im).copy()
    g = cv2.cvtColor(a, cv2.COLOR_RGB2GRAY)
    bg = cv2.medianBlur(g, 41)
    mask = np.zeros_like(g)
    x0, y0, x1, y1 = bbox
    sub = (bg[y0:y1, x0:x1].astype(int) - g[y0:y1, x0:x1].astype(int)) > 18
    mask[y0:y1, x0:x1][sub] = 255
    mask = cv2.dilate(mask, np.ones((5, 5), np.uint8), iterations=2)
    out = cv2.inpaint(a, mask, 9, cv2.INPAINT_TELEA)
    return Image.fromarray(out)

# ---------- before/after collages (top = pre, bottom = posle) ----------
# prefix, split row, logo bbox (fraction of W,H), teeth centre x (fraction), name
BA = [
    ('652391189', 537, 'ba-lumineeri-01', 0.49),
    ('818453790', 539, 'ba-lumineeri-02', 0.49),
    ('626460013', 717, 'ba-lumineeri-03', 0.50),
    ('545263856', 536, 'ba-lumineeri-04', 0.48),
    ('481782330', 537, 'ba-lumineeri-05', 0.50),
    ('807682629', 539, 'ba-protetika-01', 0.52),
    ('828810898', 536, 'ba-protetika-02', 0.58),
]
LOGO_BOX = (0.0, 0.40, 0.33, 0.60)  # watermark sits on the seam, left side
halves = {}
for pre, split, name, cxf in BA:
    im = load(pre)
    W, H = im.size
    bb = (int(LOGO_BOX[0]*W), int(LOGO_BOX[1]*H), int(LOGO_BOX[2]*W), int(LOGO_BOX[3]*H))
    top = im.crop((0, 0, W, split - 1))
    bot = im.crop((0, split + 3, W, H))
    top = remove_logo(top, (bb[0], bb[1], bb[2], top.height))
    bot = remove_logo(bot, (bb[0], 0, bb[2], bb[3] - split - 3))
    h = min(top.height, bot.height) - 4
    w = round(h * 3 / 2)
    l = int(min(max(cxf * W - w / 2, 0), W - w))
    pcrop = top.crop((l, top.height - h - 2, l + w, top.height - 2))  # keep lips, drop seam
    acrop = bot.crop((l, 2, l + w, 2 + h))
    save(pcrop, name + '-pre.webp', 900, pre)
    save(acrop, name + '-posle.webp', 900, pre)
    halves[pre] = (top, bot)
    if DBG:
        top.save(f'{DBG}/{name}-top.jpg'); bot.save(f'{DBG}/{name}-bot.jpg')

# ---------- singles ----------
im = load('481386519')                       # doctor with loupes over patient
save(crop_ratio(im, 4, 5), 'hero.webp', 1200, '481386519')

im = load('631798964')                       # doctor in white coat, curing light
save(crop_ratio(im, 4, 5, cx=820), 'doctor-portrait.webp', 900, '631798964')

im = load('649237269')                       # doctor showing X-ray to patient
save(im.crop((0, 300, 1440, 1110)), 'doctor-konsultacija.webp', 1600, '649237269')

im = load('625228557')                       # doctor + assistant at work
save(crop_ratio(im, 3, 2, cy=500, box=(0, 0, 1440, 1100)), 'tim.webp', 900, '625228557')

im = load('629750104')                       # hands, loupes, tray with ceramic model
save(crop_ratio(im, 4, 5, cx=600, cy=1050, box=(0, 250, 1440, 1800)), 'detalj-preciznost.webp', 900, '629750104')

im = load('485741532')                       # in-office whitening lamp
save(crop_ratio(im, 4, 3, cy=780), 'usluga-izbeljivanje.webp', 1600, '485741532')

im = load('831467029')                       # macro of finished ceramic work
save(crop_ratio(im, 4, 3, cy=900), 'usluga-protetika.webp', 1600, '831467029')

top, bot = halves['626460013']               # 'posle' half of the strongest veneer case
save(crop_ratio(bot, 4, 3, cx=720, cy=bot.height/2), 'usluga-lumineeri.webp', 1600, '626460013')

# ---------- logo ----------
lg = Image.open(raw('Logo')).convert('L')
a = np.asarray(lg).astype(float)
alpha = np.clip((255 - a) * 1.15, 0, 255)          # ink -> opaque, white -> transparent
alpha[alpha < 12] = 0
ys, xs = np.where(alpha > 40)
pad = 8
box = (xs.min()-pad, ys.min()-pad, xs.max()+pad+1, ys.max()+pad+1)
ink = (17, 24, 39)                                   # --c-text #111827
rgba = np.zeros(a.shape + (4,), np.uint8); rgba[..., :3] = ink; rgba[..., 3] = alpha.astype(np.uint8)
logo = Image.fromarray(rgba, 'RGBA').crop(box)
logo.save(os.path.join(OUT, 'logo.png'), optimize=True)
log.append(('logo.png', 'Logo.jpg', logo.size))
h = 96; lw = logo.resize((round(logo.width*h/logo.height), h), Image.LANCZOS)
lw.save(os.path.join(OUT, 'logo.webp'), 'WEBP', quality=90, method=6)
log.append(('logo.webp', 'Logo.jpg', lw.size))

# white variant for dark backgrounds / og-cover
wl = np.array(logo); wl[..., :3] = 255
white = Image.fromarray(wl, 'RGBA')

# ---------- og-cover 1200x630 ----------
og = Image.new('RGB', (1200, 630), (11, 59, 70))     # --c-primary #0B3B46
photo = crop_ratio(load('481386519'), 560, 630, cx=900, cy=500, box=(300, 0, 1440, 1300)).resize((560, 630), Image.LANCZOS)
og.paste(photo, (640, 0))
wl_s = white.resize((460, round(white.height*460/white.width)), Image.LANCZOS)
og.paste(wl_s, ((640-460)//2, (630-wl_s.height)//2), wl_s)
og.save(os.path.join(OUT, 'og-cover.webp'), 'WEBP', quality=82, method=6)
og.save(os.path.join(OUT, 'og-cover.jpg'), 'JPEG', quality=85, optimize=True, progressive=True)
log += [('og-cover.webp', '481386519 + Logo.jpg', og.size), ('og-cover.jpg', '481386519 + Logo.jpg', og.size)]

for r in log:
    print(*r, sep=' | ')
