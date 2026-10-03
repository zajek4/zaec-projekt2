<?php
/**
 * Template Name: 3D Scroll Phone Demo
 * Template Post Type: page
 *
 * @package Custom_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$scroll_phone_model_url = get_template_directory_uri() . '/assets/models/Mobitel-ekran_restorana.glb';
$scroll_phone_vendor_url = get_template_directory_uri() . '/assets/js/vendor';

get_header();
?>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }

  html { background: #0a0a0a; }

  body {
    margin: 0;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    background: #0a0a0a;
    color: #f5f5f7;
  }

  #scroll-phone-canvas {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    z-index: 1;
    pointer-events: none;
  }

  #scroll-phone-canvas canvas { display: block; }

  .scroll-phone-content {
    position: relative;
    z-index: 2;
    pointer-events: none;
  }

  .scroll-phone-section {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 0 8vw;
  }

  .scroll-phone-section h1,
  .scroll-phone-section h2 {
    margin: 0;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    font-size: clamp(2rem, 5vw, 4rem);
    font-weight: 600;
    line-height: normal;
    max-width: 600px;
    color: #f5f5f7;
    text-shadow: 0 2px 20px rgba(0, 0, 0, 0.8);
  }

  .scroll-phone-section p {
    margin-top: 1rem;
    max-width: 460px;
    font-size: 1.1rem;
    line-height: normal;
    color: #a1a1a6;
    text-shadow: 0 2px 12px rgba(0, 0, 0, 0.8);
  }

  .scroll-phone-section--right {
    align-items: flex-end;
    text-align: right;
  }

  .scroll-phone-section--right h2,
  .scroll-phone-section--right p { margin-left: auto; }

  #scroll-phone-loading {
    position: fixed;
    inset: 0;
    background: #0a0a0a;
    z-index: 10;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    color: #a1a1a6;
    transition: opacity 0.5s ease;
  }
</style>

<div id="scroll-phone-loading">Učitavanje modela…</div>
<div id="scroll-phone-canvas"></div>

<main id="primary" class="scroll-phone-content">
  <section class="scroll-phone-section">
    <h1>Lorem ipsum</h1>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
  </section>

  <section class="scroll-phone-section scroll-phone-section--right">
    <h2>Lorem ipsum dolor.</h2>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
  </section>

  <section class="scroll-phone-section">
    <h2>Lorem ipsum dolor sit.</h2>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis aute irure dolor in reprehenderit in voluptate velit.</p>
  </section>

  <section class="scroll-phone-section scroll-phone-section--right">
    <h2>Lorem ipsum.</h2>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Excepteur sint occaecat cupidatat non proident.</p>
  </section>
</main>

<script type="importmap">
{
  "imports": {
    "three": "<?php echo esc_url( $scroll_phone_vendor_url . '/three.module.js' ); ?>",
    "three/addons/": "<?php echo esc_url( $scroll_phone_vendor_url . '/three-addons/' ); ?>"
  }
}
</script>
<script src="<?php echo esc_url( $scroll_phone_vendor_url . '/gsap.min.js' ); ?>"></script>
<script src="<?php echo esc_url( $scroll_phone_vendor_url . '/ScrollTrigger.min.js' ); ?>"></script>

<script type="module">
import * as THREE from "three";
import { GLTFLoader } from "three/addons/loaders/GLTFLoader.js";

const loading = document.getElementById("scroll-phone-loading");
const container = document.getElementById("scroll-phone-canvas");

if (!window.gsap || !window.ScrollTrigger) {
  loading.textContent = "Animacija se nije mogla učitati. Osvježi stranicu i pokušaj ponovno.";
  throw new Error("GSAP ili ScrollTrigger nije učitan.");
}

gsap.registerPlugin(ScrollTrigger);

if ("scrollRestoration" in history) {
  history.scrollRestoration = "manual";
}
window.scrollTo(0, 0);

const scene = new THREE.Scene();
const camera = new THREE.PerspectiveCamera(35, window.innerWidth / window.innerHeight, 0.1, 100);
camera.position.set(0, 0, 8);

const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true, powerPreference: "high-performance" });
renderer.setSize(window.innerWidth, window.innerHeight);
renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
renderer.outputColorSpace = THREE.SRGBColorSpace;
container.appendChild(renderer.domElement);

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

const MODEL_URL = <?php echo wp_json_encode( $scroll_phone_model_url ); ?>;
const SCREEN_Y = 0;
const SIDE_OFFSET = 1.9;
let phone = null;

new GLTFLoader().load(
  MODEL_URL,
  (gltf) => {
    const model = gltf.scene;
    const box = new THREE.Box3().setFromObject(model);
    const size = new THREE.Vector3();
    const center = new THREE.Vector3();
    box.getSize(size);
    box.getCenter(center);

    const scale = (4 / Math.max(size.x, size.y, size.z)) * 0.6;
    model.scale.setScalar(scale);
    model.position.set(-center.x * scale, -center.y * scale, -center.z * scale);

    phone = new THREE.Group();
    phone.add(model);
    phone.rotation.set(0, SCREEN_Y, 0);
    scene.add(phone);

    loading.style.opacity = "0";
    window.setTimeout(() => { loading.style.display = "none"; }, 500);
    initScrollAnimation();
  },
  (progress) => {
    if (progress.total) {
      loading.textContent = `Učitavanje modela… ${Math.round((progress.loaded / progress.total) * 100)}%`;
    }
  },
  (error) => {
    console.error("Greška pri učitavanju GLB modela:", error);
    loading.textContent = "Model se nije mogao učitati. Osvježi stranicu i pokušaj ponovno.";
  }
);

function initScrollAnimation() {
  const sections = Array.from(document.querySelectorAll(".scroll-phone-section"));
  const count = sections.length;
  if (count < 2 || !phone) return;

  const xFor = (index) => sections[index].classList.contains("scroll-phone-section--right") ? -SIDE_OFFSET : SIDE_OFFSET;
  const step = 1 / (count - 1);

  phone.position.x = xFor(0);
  phone.rotation.y = SCREEN_Y;

  const timeline = gsap.timeline({
    scrollTrigger: {
      trigger: document.body,
      start: "top top",
      end: "bottom bottom",
      scrub: 1.2,
      invalidateOnRefresh: true,
    },
  });

  for (let index = 0; index < count - 1; index += 1) {
    const position = index * step;
    timeline.to(phone.rotation, { y: `+=${Math.PI * 2}`, duration: step, ease: "power1.inOut" }, position);
    timeline.to(phone.position, { x: xFor(index + 1), duration: step, ease: "power2.inOut" }, position);
  }

  ScrollTrigger.refresh();
  window.scrollTo(0, 0);
}

function animate() {
  window.requestAnimationFrame(animate);
  renderer.render(scene, camera);
}
animate();

let resizeTimer = 0;
window.addEventListener("resize", () => {
  window.clearTimeout(resizeTimer);
  resizeTimer = window.setTimeout(() => {
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(window.innerWidth, window.innerHeight);
    ScrollTrigger.refresh();
  }, 100);
}, { passive: true });
</script>

<?php
get_footer();
