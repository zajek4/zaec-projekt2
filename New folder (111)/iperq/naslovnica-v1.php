<?php
/**
 * Template Name: Naslovnica V1
 * Template Post Type: page
 *
 * Legacy 3D scroll rotate naslovnica s GLB modelom.
 *
 * Ovaj predložak namjerno NE koristi get_header() / get_footer() iz teme
 * (nema site-header navigacije, sidebar-a i sl.) jer je zamišljen kao
 * full-bleed "hero" iskustvo preko cijelog ekrana, baš kao originalni
 * samostalni index.html. wp_head() / wp_body_open() / wp_footer() se i
 * dalje pozivaju radi kompatibilnosti s pluginovima, admin barom itd.
 *
 * Predložak se sada koristi samo kada ga ručno odaberete na stranici.
 *
 * @package Custom_Theme
 */

// Apsolutni URL do GLB modela unutar teme — radi na svakoj domeni/instalaciji.
$custom_theme_glb_url = esc_url( get_template_directory_uri() . '/assets/models/Mobitel-ekran_restorana.glb' );
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="preload" href="<?php echo $custom_theme_glb_url; ?>" as="fetch" type="model/gltf-binary" crossorigin="anonymous" fetchpriority="high" />
<?php wp_head(); ?>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }

  body {
    font-family: "Satoshi", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    min-height: 100vh;
    overflow-x: clip;
    background-color: #1D0035;
    /* Shared violet glow canvas (design-tokens.css) instead of a stretched bitmap. */
    background-image:
      radial-gradient(circle at 95% 9%, var(--iperq-glow-violet), transparent 22%),
      radial-gradient(circle at 4% 33%, var(--iperq-glow-purple), transparent 24%),
      radial-gradient(circle at 94% 57%, var(--iperq-glow-orchid), transparent 22%),
      radial-gradient(circle at 6% 85%, var(--iperq-glow-purple), transparent 22%),
      var(--iperq-canvas-base);
    background-position: center top;
    background-repeat: no-repeat;
    background-size: cover;
  }

  /* 3D canvas pripada How It Works sekciji i scrolla zajedno s njom. */
  #canvas-container {
    position: absolute;
    top: -400px;
    right: 0;
    bottom: 0;
    left: 0;
    width: 100%;
    z-index: 3;
    pointer-events: none;
    overflow: visible;
  }

  #canvas-container canvas {
    display: block;
    transform: translateZ(0);
    will-change: transform;
  }

  /* Scrollabilni sadržaj iznad canvasa */
  .content {
    position: relative;
    z-index: 2;
    overflow: visible;
  }

  section {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 0 115px;
  }

  .hero {
    min-height: 0;
    align-items: center;
    justify-content: flex-start;
    padding-top: 250px;
    padding-bottom: 364px;
    text-align: center;
  }

  .hero__content {
    width: 1040px;
    margin: 0 auto;
  }

  .hero h1 {
    max-width: none;
    margin: 0;
    font-size: 100px;
    font-weight: 700;
    font-style: normal;
    line-height: 72px;
    letter-spacing: -1.8px;
    text-align: center;
    text-shadow: none;
    color: #ffffff;
  }

  .hero__title-line {
    display: block;
  }

  .hero__title-line--accent {
    color: #00ebae;
    font-size: 72px;
    line-height: 72px;
  }

  .hero .hero__description {
    max-width: 660px;
    margin: 24px auto 0;
    color: rgba(255, 255, 255, 0.6);
    font-family: "Satoshi", sans-serif;
    font-size: 20px;
    font-weight: 400;
    font-style: normal;
    line-height: 32.5px;
    letter-spacing: 0;
    text-align: center;
    text-shadow: none;
  }

  .hero__actions {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
    margin-top: 64px;
    pointer-events: auto;
  }

  .hero__button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    padding: 16px 24px;
    border: 1px solid transparent;
    border-radius: 9px;
    font-family: "Plus Jakarta Sans", "Satoshi", sans-serif;
    font-size: 20px;
    font-weight: 700;
    font-style: normal;
    line-height: 24px;
    letter-spacing: 0;
    text-align: center;
    text-decoration: none;
  }

  .hero__button--primary {
    background: #00ebae;
    color: #2d0051;
  }

  .hero__button--secondary {
    border-color: rgba(255, 255, 255, 0.22);
    background: rgba(255, 255, 255, 0.02);
    color: #fff;
  }

  .hero__button-arrow {
    width: 17px;
    height: auto;
  }

  .hero__button--secondary .hero__button-arrow {
    filter: brightness(0) invert(1);
  }

  .hero .hero__note {
    max-width: none;
    margin: 13px auto 0;
    color: rgba(255, 255, 255, 0.6);
    font-family: "Satoshi", sans-serif;
    font-size: 14px;
    font-weight: 500;
    font-style: normal;
    line-height: 32.5px;
    letter-spacing: 0;
    text-align: center;
    text-shadow: none;
  }

  .how-it-works {
    display: block;
    padding: 0;
    overflow: visible;
  }

  .how-it-works::after {
    content: "";
    display: block;
    padding-top: 620px;
  }

  .how-it-works__stage {
    position: sticky;
    top: 0;
    width: 100%;
    min-height: 100vh;
    padding: 90px 0 80px;
    overflow: visible;
  }

  .how-it-works__panel {
    position: relative;
    width: 1800px;
    margin: 0 auto;
    padding-bottom: 372px;
  }

  .how-it-works__background {
    position: relative;
    width: 100%;
    height: 1000px;
    padding-top: 587.5px;
    border-radius: 32px;
    background-image:
      url("<?php echo esc_url( get_template_directory_uri() . '/assets/images/mask-group.svg?v=' . filemtime( get_template_directory() . '/assets/images/mask-group.svg' ) ); ?>"),
      linear-gradient(#d04cf4, #d04cf4);
    background-position: center top, center top;
    background-repeat: no-repeat, no-repeat;
    background-size: calc(100% + 40px) calc(100% + 40px), 100% 100%;
  }

  .how-it-works__heading {
    position: relative;
    z-index: 1;
    width: 100%;
    color: #fff;
    text-align: center;
  }

  .how-it-works__heading h2 {
    max-width: none;
    margin: 0;
    font-family: "Author", "Satoshi", sans-serif;
    font-size: 72px;
    font-weight: 700;
    font-style: normal;
    line-height: 72px;
    letter-spacing: -1.8px;
    text-align: center;
    text-shadow: none;
  }

  .how-it-works__heading p {
    max-width: none;
    margin: 8px 0 0;
    color: rgba(255, 255, 255, 0.72);
    font-family: "Satoshi", sans-serif;
    font-size: 24px;
    font-weight: 500;
    font-style: normal;
    line-height: 32.5px;
    letter-spacing: 0;
    text-align: center;
    text-shadow: none;
  }

  .how-it-works__cards {
    position: relative;
    z-index: 2;
    display: flex;
    gap: 20px;
    width: 1360px;
    height: 572px;
    justify-content: center;
    align-items: stretch;
    margin: 100px auto 0;
  }

  .how-it-works__card {
    position: relative;
    display: flex;
    flex-direction: column;
    width: 440px;
    padding: 48px;
    border-radius: 6px;
    background: #2d0051;
    color: #fff;
  }

  .how-it-works__card h3 {
    max-width: 360px;
    margin: 0;
    font-family: "Author", "Satoshi", sans-serif;
    font-size: 40px;
    font-weight: 596;
    font-style: normal;
    line-height: 40px;
    letter-spacing: -1.8px;
  }

  .how-it-works__card p {
    max-width: 360px;
    margin: 16px 0 0;
    color: rgba(255, 255, 255, 0.72);
    font-family: "Satoshi", sans-serif;
    font-size: 20px;
    font-weight: 400;
    font-style: normal;
    line-height: 32.5px;
    letter-spacing: 0;
    text-shadow: none;
  }

  .how-it-works__icon {
    display: block;
    width: auto;
    height: 204px;
    margin-top: auto;
    margin-bottom: 0;
    object-fit: contain;
    align-self: baseline;
  }

  .how-it-works__phone-slot {
    width: 112px;
    margin: auto auto 0;
    padding-top: 284px;
    pointer-events: none;
  }

  section h1, section h2 {
    font-family: "Author", "Satoshi", sans-serif;
    font-size: 64px;
    font-weight: 600;
    max-width: 600px;
    text-shadow: 0 2px 20px rgba(0,0,0,0.8);
  }

  section p {
    margin-top: 16px;
    max-width: 460px;
    font-size: 18px;
    color: #a1a1a6;
    text-shadow: 0 2px 12px rgba(0,0,0,0.8);
  }

  .right {
    align-items: flex-end;
    text-align: right;
  }
  .right h2, .right p { margin-left: auto; }

</style>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php get_template_part( 'template-parts/site', 'header' ); ?>

<div id="primary" class="content">
  <section class="hero">
    <div class="hero__content">
      <h1>
        <span class="hero__title-line">Give Customers</span>
        <span class="hero__title-line hero__title-line--accent">Reasons To Stay Loyal.</span>
      </h1>

      <p class="hero__description">Bring a digital loyalty program to your restaurants, cafés &amp; bars. Connect your business with a dedicated cashier app for your team &amp; a rewards app for your customers.</p>

      <div class="hero__actions">
        <a class="hero__button hero__button--primary" href="#get-started">
          <span>Get Started</span>
          <img class="hero__button-arrow" src="https://dev.michel.hr/iperq/wp-content/uploads/2026/09/Arrow-right.svg" alt="" width="17" />
        </a>
        <a class="hero__button hero__button--secondary" href="#get-started">
          <span>Talk To Us</span>
          <img class="hero__button-arrow" src="https://dev.michel.hr/iperq/wp-content/uploads/2026/09/Arrow-right.svg" alt="" width="17" />
        </a>
      </div>

      <p class="hero__note">Set up your program yourself, or talk to our team first.</p>
    </div>
  </section>

  <section id="get-started" class="how-it-works">
    <div class="how-it-works__stage">
      <div id="canvas-container"></div>

      <div class="how-it-works__panel">
        <div class="how-it-works__background">
          <div class="how-it-works__heading">
            <h2>How It Works?</h2>
            <p>One program. Everyone connected.</p>
          </div>

          <div class="how-it-works__cards">
            <article class="how-it-works__card">
              <h3>You set the reward system.</h3>
              <p>Choose digital stamps or points, define what customers can earn & add your business locations.</p>
              <img class="how-it-works__icon" src="https://dev.michel.hr/iperq/wp-content/uploads/2026/09/magnific_remove-the-bagguette-part_Bh5RmIWoQR-1.svg" alt="" />
            </article>

            <article class="how-it-works__card">
              <h3>Your team makes it happen.</h3>
              <p>Staff scan customer QR codes in the cashier app to award stamps & points or approve rewards & discounts.</p>
              <div class="how-it-works__phone-slot" aria-label="3D mobile app preview"></div>
            </article>

            <article class="how-it-works__card">
              <h3>Your customers stay loyal.</h3>
              <p>Customers track their progress, check available rewards & show their QR code when it's time to collect or redeem.</p>
              <img class="how-it-works__icon" src="https://dev.michel.hr/iperq/wp-content/uploads/2026/09/Artwork.svg" alt="" />
            </article>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- Three.js + GLTFLoader + GSAP (svi importi preko import map / CDN) -->
<script type="importmap">
{
  "imports": {
    "three": "https://cdnjs.cloudflare.com/ajax/libs/three.js/0.160.0/three.module.js",
    "three/addons/": "https://cdn.jsdelivr.net/npm/three@0.160.0/examples/jsm/"
  }
}
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

<script type="module">
import * as THREE from "three";
import { GLTFLoader } from "three/addons/loaders/GLTFLoader.js";

gsap.registerPlugin(ScrollTrigger);

// ---------- SCROLL NA VRH PRI UČITAVANJU ----------
if ("scrollRestoration" in history) {
  history.scrollRestoration = "manual";
}
window.scrollTo(0, 0);

// ---------- SCENA ----------
const container = document.getElementById("canvas-container");
let canvasHeight = container.clientHeight || window.innerHeight;

const scene = new THREE.Scene();

const camera = new THREE.PerspectiveCamera(
  35,
  window.innerWidth / canvasHeight,
  0.1,
  100
);
camera.position.set(0, 0, 8);

const maxPixelRatio = 0.75;
const renderer = new THREE.WebGLRenderer({
  antialias: false,
  alpha: true,
  powerPreference: "high-performance",
});
renderer.setSize(window.innerWidth, canvasHeight);
renderer.setPixelRatio(Math.min(window.devicePixelRatio, maxPixelRatio));
renderer.outputColorSpace = THREE.SRGBColorSpace;
container.appendChild(renderer.domElement);

// ---------- SVJETLA ----------
const keyLight = new THREE.DirectionalLight(0xffffff, 3);
keyLight.position.set(5, 5, 5);
scene.add(keyLight);

const fillLight = new THREE.DirectionalLight(0xffffff, 1.2);
fillLight.position.set(-5, -2, 3);
scene.add(fillLight);

const rimLight = new THREE.DirectionalLight(0x88aaff, 2);
rimLight.position.set(0, 3, -5);
scene.add(rimLight);

scene.add(new THREE.AmbientLight(0xffffff, 0.4));

// ---------- UČITAVANJE MODELA ----------
// Putanja do GLB-a dolazi iz WordPressa (assets/models/ unutar teme),
// pa radi na bilo kojoj domeni i bez obzira u koji je folder WP instaliran.
const MODEL_URL = "<?php echo $custom_theme_glb_url; ?>";

let phone = null;
let phoneBaseHeight = 0;
const loader = new GLTFLoader();

loader.load(
  MODEL_URL,
  (gltf) => {
    const model = gltf.scene;

    const box = new THREE.Box3().setFromObject(model);
    const size = new THREE.Vector3();
    const center = new THREE.Vector3();
    box.getSize(size);
    box.getCenter(center);

    const maxDim = Math.max(size.x, size.y, size.z);
    const scale = (4 / maxDim) * 0.6;
    model.scale.setScalar(scale);
    model.position.set(
      -center.x * scale,
      -center.y * scale,
      -center.z * scale
    );

    phone = new THREE.Group();
    phone.add(model);
    phone.updateMatrixWorld(true);
    phoneBaseHeight = new THREE.Box3().setFromObject(phone).getSize(new THREE.Vector3()).y;

    phone.rotation.set(0, SCREEN_Y, 0);

    scene.add(phone);
    requestRender();

    initScrollAnimation();
  },
  undefined,
  (error) => {
    console.error("Greška pri učitavanju GLB modela:", error);
  }
);

// ---------- SCROLL ANIMACIJA (GSAP ScrollTrigger) ----------
const SCREEN_Y = 0;

function initScrollAnimation() {
  const section = document.querySelector(".how-it-works");
  const stage = document.querySelector(".how-it-works__stage");
  const phoneSlot = document.querySelector(".how-it-works__phone-slot");
  if (!section || !stage || !phoneSlot || !phoneBaseHeight) return;

  phone.rotation.y = SCREEN_Y;

  const PHONE_SIZE_FACTOR = 0.95;
  const INITIAL_PHONE_HEIGHT = 750 * PHONE_SIZE_FACTOR;
  const INITIAL_PHONE_CENTER_FROM_STAGE_TOP = 125;
  const initialPosition = new THREE.Vector2();
  const targetPosition = new THREE.Vector2();
  let initialScale = 1;
  let targetScale = 1;

  const updatePhoneLayout = () => {
    const canvasRect = renderer.domElement.getBoundingClientRect();
    const stageRect = stage.getBoundingClientRect();
    const slotRect = phoneSlot.getBoundingClientRect();
    const initialCenterY = stageRect.top + INITIAL_PHONE_CENTER_FROM_STAGE_TOP - canvasRect.top;
    const slotCenterX = slotRect.left + slotRect.width / 2 - canvasRect.left;
    const targetPhoneHeight = slotRect.height * 0.85 * PHONE_SIZE_FACTOR;
    const slotCenterY = slotRect.bottom - targetPhoneHeight / 2 - canvasRect.top;
    const visibleHeight = 2 * Math.tan(THREE.MathUtils.degToRad(camera.fov / 2)) * camera.position.z;
    const visibleWidth = visibleHeight * camera.aspect;
    const pixelsPerWorldUnit = canvasRect.height / visibleHeight;

    initialPosition.set(
      0,
      (0.5 - initialCenterY / canvasRect.height) * visibleHeight
    );

    targetPosition.set(
      (slotCenterX / canvasRect.width - 0.5) * visibleWidth,
      (0.5 - slotCenterY / canvasRect.height) * visibleHeight
    );

    initialScale = INITIAL_PHONE_HEIGHT / (phoneBaseHeight * pixelsPerWorldUnit);
    targetScale = targetPhoneHeight / (phoneBaseHeight * pixelsPerWorldUnit);
  };

  updatePhoneLayout();
  phone.position.set(initialPosition.x, initialPosition.y, 0);
  phone.scale.setScalar(initialScale);

  const settle = gsap.timeline({
    onUpdate: requestRender,
    scrollTrigger: {
      trigger: section,
      start: "top top",
      end: "+=620",
      scrub: true,
      invalidateOnRefresh: true,
      onRefreshInit: updatePhoneLayout,
      onRefresh: updatePhoneLayout,
    },
  });

  settle.fromTo(
    phone.scale,
    { x: () => initialScale, y: () => initialScale, z: () => initialScale },
    { x: () => targetScale, y: () => targetScale, z: () => targetScale, duration: 1, ease: "none" },
    0
  );

  settle.fromTo(
    phone.position,
    { x: () => initialPosition.x, y: () => initialPosition.y },
    { x: () => targetPosition.x, y: () => targetPosition.y, duration: 1, ease: "none" },
    0
  );

  ScrollTrigger.refresh();
  window.scrollTo(0, 0);
}

// ---------- RENDERANJE SAMO KADA SE SCENA PROMIJENI ----------
let renderFrame = 0;

function requestRender() {
  if (renderFrame) return;

  renderFrame = requestAnimationFrame(() => {
    renderFrame = 0;
    renderer.render(scene, camera);
  });
}
requestRender();

// ---------- RESIZE ----------
let viewportWidth = window.innerWidth;
let viewportHeight = window.innerHeight;
let resizeTimer = 0;

window.addEventListener("resize", () => {
  clearTimeout(resizeTimer);
  resizeTimer = setTimeout(() => {
    const nextWidth = window.innerWidth;
    const nextHeight = window.innerHeight;
    const widthChanged = nextWidth !== viewportWidth;
    const significantHeightChange = Math.abs(nextHeight - viewportHeight) > 120;

    // Mobilna adresna traka mijenja samo visinu viewporta tijekom scrollanja.
    if (!widthChanged && !significantHeightChange) return;

    viewportWidth = nextWidth;
    viewportHeight = nextHeight;
    canvasHeight = container.clientHeight || nextHeight;
    camera.aspect = nextWidth / canvasHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(nextWidth, canvasHeight);
    ScrollTrigger.refresh();
    requestRender();
  }, 180);
}, { passive: true });
</script>

<?php wp_footer(); ?>

</body>
</html>
