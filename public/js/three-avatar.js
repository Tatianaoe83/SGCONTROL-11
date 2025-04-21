import * as THREE from 'https://esm.sh/three@0.175.0';
import { GLTFLoader } from 'https://esm.sh/three@0.175.0/examples/jsm/loaders/GLTFLoader.js';
import { OrbitControls } from 'https://esm.sh/three@0.175.0/examples/jsm/controls/OrbitControls.js';

console.log('✅ Three.js módulo funcionando');

const container = document.getElementById('three-container');
const scene = new THREE.Scene();
const camera = new THREE.PerspectiveCamera(75, container.offsetWidth / container.offsetHeight, 0.1, 1000);
const renderer = new THREE.WebGLRenderer({ antialias: true });
renderer.setSize(container.offsetWidth, container.offsetHeight);
container.appendChild(renderer.domElement);



// Fondo panorámico elegante
const textureLoader = new THREE.TextureLoader();
textureLoader.load('/storage/fondos/escena3.jpg', (texture) => {
    texture.mapping = THREE.EquirectangularReflectionMapping;
    scene.background = texture;
});

// GLTF Avatar
const loader = new GLTFLoader();
loader.load('/storage/modelos/scene.gltf', (gltf) => {
    const model = gltf.scene;
    model.scale.set(2.5, 2.5, 2.5);
    model.position.set(2, -3, 0);
    scene.add(model);

    /*const model = gltf.scene;
    model.scale.set(2.5, 2.5, 2.5); // más grande
    model.position.set(0, -1, 0); // bajado un poco
    scene.add(model);*/
});

// OrbitControls para mover cámara
const controls = new OrbitControls(camera, renderer.domElement);
controls.enableDamping = true;

camera.position.set(1.5, 1, 3); // posición desde la derecha
camera.lookAt(new THREE.Vector3(-2, 0, 0)); // enfoca al avatar

const animate = () => {
    requestAnimationFrame(animate);
    controls.update();
    renderer.render(scene, camera);
};

animate();

window.addEventListener('resize', () => {
    camera.aspect = container.offsetWidth / container.offsetHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(container.offsetWidth, container.offsetHeight);
});