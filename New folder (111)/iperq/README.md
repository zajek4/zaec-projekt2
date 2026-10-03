# Custom Starter Theme

Minimalna, ali kompletna starter WordPress tema. Sadrži svu standardnu template hijerarhiju i spremna je za daljnju nadogradnju (custom post types, ACF polja, block patterns, itd.).

## Instalacija

1. Zakomprimiraj (zip) cijelu mapu `custom-theme` ili je kopiraj direktno u `wp-content/themes/`.
2. U WP adminu idi na **Izgled → Teme** i aktiviraj "Custom Starter Theme".
3. Postavi izbornike: **Izgled → Izbornici** → dodijeli lokacije "Glavni izbornik" i "Footer izbornik".
4. Widgete dodaj na **Izgled → Widgeti** ("Bočna traka" i "Footer").
5. Logo i boju isticanja podesi kroz **Izgled → Prilagodi (Customizer)**.

## Struktura datoteka

```
custom-theme/
├── style.css                  # Glavni CSS + WP theme header
├── functions.php              # Setup, enqueue, widgeti, menu lokacije
├── index.php                  # Fallback predložak
├── header.php / footer.php    # Zaglavlje / podnožje
├── sidebar.php                # Bočna traka
├── single.php                 # Pojedinačni post
├── page.php                   # Statička stranica
├── archive.php                # Arhive (kategorije, tagovi, autori...)
├── search.php                 # Rezultati pretrage
├── searchform.php             # Custom forma pretrage
├── 404.php                    # Stranica greške
├── comments.php               # Predložak komentara
├── front-page-OFF.php         # Disabled front-page override (kept only as reference)
├── template-parts/
│   ├── content.php            # Default prikaz posta u loopu
│   ├── content-single.php
│   ├── content-page.php
│   ├── content-search.php
│   └── content-none.php       # Prikaz kad nema rezultata
├── inc/
│   ├── template-tags.php      # Custom template funkcije
│   ├── template-functions.php # Filteri / markup poboljšanja
│   └── customizer.php         # WP Customizer opcije (boja, live preview)
├── js/
│   ├── navigation.js          # Mobilni izbornik toggle
│   ├── main.js                # Prostor za tvoj JS
│   └── customizer.js          # Live preview bindovi
└── assets/
    ├── css/editor-style.css   # Stilovi unutar block editora
    ├── images/                # Prazna mapa za slike (dodaj screenshot.png ovdje)
    └── models/
        └── Mobitel-ekran_restorana.glb   # 3D model korišten na naslovnici
```

## Naslovnica s 3D modelom (front-page.php)

`front-page.php` je samostalan, full-bleed predložak (Three.js + GSAP ScrollTrigger) koji **ne** koristi `header.php`/`footer.php` teme — nema site navigacije preko njega, baš kao originalni `index.html`. WordPress ga automatski koristi kao naslovnicu tek kad to eksplicitno uključiš:

1. **Postavke → Čitanje** → "Naslovnica prikazuje" → odaberi **"Statična stranica"**.
2. Za "Naslovnica" polje odaberi bilo koju postojeću stranicu (sadržaj te stranice se neće prikazati — `front-page.php` uvijek ima prednost dok postoji u temi).
3. Spremi.

GLB model se nalazi u `assets/models/Mobitel-ekran_restorana.glb` i putanja se u `front-page.php` gradi dinamički:

```php
$custom_theme_glb_url = esc_url( get_template_directory_uri() . '/assets/models/Mobitel-ekran_restorana.glb' );
```

Radi toga model radi na bilo kojoj domeni i bez obzira je li WP instaliran u root ili podmapi — nema potrebe ručno mijenjati putanju.

Ako želiš zamijeniti model drugom `.glb` datotekom: ubaci novu datoteku u `assets/models/` i promijeni naziv datoteke u toj liniji u `front-page.php`.

## Napomene

- Dodaj `screenshot.png` (1200×900px) u korijen teme da se prikaže lijepa preview slika u popisu tema.
- Text domain je `custom-theme` — po potrebi generiraj `.pot` datoteku za prijevode u `languages/`.
- Boja isticanja postavlja se preko Customizera (`inc/customizer.php`), a primjenjuje se inline u `<head>`.
- Za custom post types / taxonomije dodaj novi `inc/custom-post-types.php` i uključi ga u `functions.php`.
- Tema koristi čisti PHP + vanilla JS, bez build koraka (nema potrebe za npm/webpack).

## Homepage templates

- `front-page.php` is the canonical site homepage and loads the current IPERQ business landing from `naslovnica.php`.
- `naslovnica.php` remains the selectable **Naslovnica AI** page template and is the single source of truth for that landing.
- `naslovnica-v1.php` is the previous standalone 3D homepage, preserved as the selectable **Naslovnica V1** template.


## Current homepage template behaviour

- `front-page.php` is intentionally disabled as `front-page-OFF.php`.
- WordPress therefore respects the static page selected in **Settings → Reading** and that page's assigned template.
- `naslovnica.php` is the selectable **Naslovnica AI** template.
- `naslovnica-v1.php` preserves the previous standalone 3D homepage as **Naslovnica V1**.


## Shared IPERQ design classes

Use these global classes before creating page-specific duplicates:

- `.iperq-display-xl` — primary hero line (desktop 100/72, mobile 56/44)
- `.iperq-display-accent` — hero accent line (desktop 72/72, mobile 30/28)
- `.iperq-heading-xl` — primary section heading (desktop 72/72, mobile 44/40)
- `.iperq-heading-lg` — card/subsection heading (desktop 40/40, mobile 30/28)
- `.iperq-hero-lead` — hero lead copy (desktop 20/32.5, mobile 16/24)
- `.iperq-hero-control` — primary hero/tab control sizing (desktop 56px/20px, mobile 48px/16px)
- `.iperq-text-md`, `.iperq-text-sm`, `.iperq-caption` — reusable body/caption scales

Page CSS should only define layout, color/state variants, and components that are genuinely page-specific.

## Performance notes (1.0.27)

- Plus Jakarta Sans no longer requires a Google Fonts request; the legacy 700 weight is self-hosted.
- Author and Satoshi frontend fonts use WOFF2. Critical hero weights are preloaded only on Business/Pricing pages.
- The Business hero uses viewport-aware `<picture>` sources so mobile does not request the three desktop POS layers and desktop does not request the mobile composite.
- The mobile hero visual reserves its 390:229 aspect ratio and uses a lossless WebP source with PNG fallback.
- Below-the-fold Business imagery, Pricing demo artwork and footer artwork use native lazy loading / async decoding.
- Homepage upload URLs are generated with `content_url()` instead of being tied to the staging domain.
- Skeleton/shimmer has intentionally not been added yet: the first optimization pass removes real network/layout work before adding perceived-loading UI.

## Header behaviour (1.0.30)

- The global header is always fixed; the previous Standard / Desktop + mobile / Mobile only setting has been removed.
- On desktop (>900px), the full header begins morphing into the existing mint compact navigation as soon as the page leaves scroll position 0, and expands again when the user returns to the very top.
- The desktop compact shell uses the same menu toggle, logo treatment, Get Started styling, expandable menu panel and submenu interactions as the mobile component, with a 650px shell width.
- Mobile/tablet retains the existing layout and the <=600px scrolled offset behaviour.
- The header transition is CSS-driven and the scroll state is updated through requestAnimationFrame; GSAP is intentionally not loaded for this two-state interaction.
- The 1.0.30 motion pass uses a dedicated mint morph surface revealed from the center (no transparent-to-mint wash), keeps the 16px radius geometrically present throughout the desktop state, and pulls left/right navigation groups inward before they fade and collapse.
- On desktop, the compact morph now begins as soon as the page leaves scroll position 0 and expands again only when the user returns to the very top.
