/* Diverse Pathwais — flight scene
   ------------------------------------------------------------------------
   One scroll-driven 3D airliner shared by every page, plus a small fleet in
   the home hero. The plane is built procedurally (no model download), lit by
   a generated sky environment, and glides between "waypoints" anchored to
   real DOM sections so it rides with the content like a physical object.

   three.js is resolved through the import map declared in each page's head.
   Everything degrades gracefully: no WebGL, no module support or a
   reduced-motion preference simply leaves the page as it is. */
import * as THREE from 'three';

const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
const mobileMQ = window.matchMedia('(max-width: 900px)');
const YAW_R = -0.42;           /* nose to the right, three-quarter view   */
const YAW_L = -2.72;           /* nose to the left, three-quarter view    */
const FOV = 34;
const CAM_Z = 12;

function supportsWebGL() {
  try {
    const c = document.createElement('canvas');
    return Boolean(window.WebGLRenderingContext && (c.getContext('webgl2') || c.getContext('webgl')));
  } catch (e) { return false; }
}

const clamp = (v, a, b) => (v < a ? a : v > b ? b : v);
const smooth = (t) => { t = clamp(t, 0, 1); return t * t * (3 - 2 * t); };
const lerp = (a, b, t) => a + (b - a) * t;

/* ------------------------------------------------------------ sky env --- */
function makeEnvironment() {
  const size = 64;
  const faces = [];
  for (let i = 0; i < 6; i++) {
    const c = document.createElement('canvas');
    c.width = c.height = size;
    const ctx = c.getContext('2d');
    let g;
    if (i === 2) {           /* +Y top */
      g = ctx.createRadialGradient(size * .5, size * .5, 2, size * .5, size * .5, size * .8);
      g.addColorStop(0, '#ffffff'); g.addColorStop(1, '#e3ecff');
    } else if (i === 3) {    /* -Y bottom */
      g = ctx.createLinearGradient(0, 0, 0, size);
      g.addColorStop(0, '#5f7190'); g.addColorStop(1, '#3a4a63');
    } else {
      g = ctx.createLinearGradient(0, 0, 0, size);
      g.addColorStop(0, '#f2f6ff'); g.addColorStop(.48, '#cdd9f0'); g.addColorStop(.52, '#9eb0cc'); g.addColorStop(1, '#5c6d88');
    }
    ctx.fillStyle = g;
    ctx.fillRect(0, 0, size, size);
    if (i === 0) {           /* warm sun on +X */
      const s = ctx.createRadialGradient(size * .68, size * .28, 1, size * .68, size * .28, size * .5);
      s.addColorStop(0, 'rgba(255,236,190,1)'); s.addColorStop(.35, 'rgba(255,225,160,.55)'); s.addColorStop(1, 'rgba(255,225,160,0)');
      ctx.fillStyle = s; ctx.fillRect(0, 0, size, size);
    }
    faces.push(c);
  }
  const tex = new THREE.CubeTexture(faces);
  tex.colorSpace = THREE.SRGBColorSpace;
  tex.needsUpdate = true;
  return tex;
}

/* -------------------------------------------------------------- plane --- */
const PROFILE = [
  [-2.32, 0.02], [-2.12, 0.09], [-1.75, 0.19], [-1.3, 0.29], [-0.85, 0.365],
  [-0.35, 0.39], [0.95, 0.39], [1.32, 0.372], [1.62, 0.315], [1.84, 0.225],
  [1.98, 0.11], [2.05, 0.0]
];
function radiusAt(x) {
  for (let i = 1; i < PROFILE.length; i++) {
    if (x <= PROFILE[i][0]) {
      const a = PROFILE[i - 1], b = PROFILE[i];
      return lerp(a[1], b[1], (x - a[0]) / (b[0] - a[0]));
    }
  }
  return 0;
}
function bendTail(geometry) {
  const pos = geometry.attributes.position;
  for (let i = 0; i < pos.count; i++) {
    const x = pos.getX(i);
    if (x < -0.9) pos.setY(i, pos.getY(i) + Math.pow((-0.9 - x) / 1.42, 1.7) * 0.3);
  }
  pos.needsUpdate = true;
  geometry.computeVertexNormals();
}
function latheBand(x0, x1, pad, phiStart, phiLength, steps) {
  const pts = [];
  for (let i = 0; i <= steps; i++) {
    const x = lerp(x0, x1, i / steps);
    pts.push(new THREE.Vector2(radiusAt(x) + pad, x));
  }
  const g = new THREE.LatheGeometry(pts, 40, phiStart, phiLength);
  g.rotateZ(-Math.PI / 2);
  bendTail(g);
  return g;
}
function wingGeometry(rootLead, rootTrail, tipLead, tipTrail, span, thick) {
  const s = new THREE.Shape();
  s.moveTo(rootLead, 0); s.lineTo(tipLead, span); s.lineTo(tipTrail, span); s.lineTo(rootTrail, 0); s.closePath();
  const g = new THREE.ExtrudeGeometry(s, { depth: thick, bevelEnabled: true, bevelThickness: 0.015, bevelSize: 0.025, bevelSegments: 2 });
  g.translate(0, 0, -thick / 2);
  g.rotateX(-Math.PI / 2);
  return g;
}

function buildPlane(mats) {
  const plane = new THREE.Group();

  /* fuselage */
  const curve = new THREE.CatmullRomCurve3(PROFILE.map(p => new THREE.Vector3(p[1], p[0], 0)));
  const pts = curve.getPoints(56).map(v => new THREE.Vector2(Math.max(v.x, 0), v.y));
  const fuselage = new THREE.LatheGeometry(pts, 48);
  fuselage.rotateZ(-Math.PI / 2);
  bendTail(fuselage);
  plane.add(new THREE.Mesh(fuselage, mats.body));

  /* belly + cheatlines + cockpit glazing */
  plane.add(new THREE.Mesh(latheBand(-1.7, 1.4, 0.006, -1.02, 2.04, 24), mats.navy));
  plane.add(new THREE.Mesh(latheBand(-1.7, 1.4, 0.008, 1.02, 0.07, 24), mats.gold));
  plane.add(new THREE.Mesh(latheBand(-1.7, 1.4, 0.008, -1.09, 0.07, 24), mats.gold));
  plane.add(new THREE.Mesh(latheBand(1.5, 1.8, 0.009, Math.PI - 1.15, 2.3, 8), mats.dark));

  /* cabin windows */
  const xs = [];
  for (let x = -1.1; x <= 1.2; x += 0.145) xs.push(x);
  const windows = new THREE.InstancedMesh(new THREE.BoxGeometry(0.055, 0.075, 0.02), mats.dark, xs.length * 2);
  const m = new THREE.Matrix4(), q = new THREE.Quaternion(), p = new THREE.Vector3(), sc = new THREE.Vector3(1, 1, 1);
  const phi = 0.28;
  let k = 0;
  xs.forEach(x => {
    const r = radiusAt(x) + 0.004;
    const bend = x < -0.9 ? Math.pow((-0.9 - x) / 1.42, 1.7) * 0.3 : 0;
    [1, -1].forEach(side => {
      p.set(x, r * Math.sin(phi) + bend, side * r * Math.cos(phi));
      q.setFromEuler(new THREE.Euler(side === 1 ? -phi : Math.PI + phi, 0, 0));
      m.compose(p, q, sc);
      windows.setMatrixAt(k++, m);
    });
  });
  plane.add(windows);

  /* wings */
  const wingGeo = wingGeometry(0.62, -0.5, -0.58, -0.92, 2.35, 0.075);
  const wingR = new THREE.Mesh(wingGeo, mats.wing);
  wingR.position.set(0.05, -0.17, 0); wingR.rotation.x = 0.075;
  const wingL = wingR.clone(); wingL.scale.z = -1; wingL.rotation.x = -0.075;
  plane.add(wingR, wingL);

  /* winglets */
  const wlShape = new THREE.Shape();
  wlShape.moveTo(-0.58, 0); wlShape.lineTo(-0.92, 0); wlShape.lineTo(-0.86, 0.34); wlShape.lineTo(-0.7, 0.34); wlShape.closePath();
  const wlGeo = new THREE.ExtrudeGeometry(wlShape, { depth: 0.03, bevelEnabled: false });
  wlGeo.translate(0, 0, -0.015);
  [1, -1].forEach(side => {
    const wl = new THREE.Mesh(wlGeo, mats.gold);
    wl.position.set(0.05, -0.17 + Math.sin(0.075) * 2.35, -side * 2.33);
    wl.rotation.x = -side * 0.22;
    plane.add(wl);
  });

  /* engines */
  const nacelleGeo = new THREE.CylinderGeometry(0.2, 0.185, 0.68, 30); nacelleGeo.rotateZ(Math.PI / 2);
  const lipGeo = new THREE.CylinderGeometry(0.212, 0.2, 0.09, 30); lipGeo.rotateZ(Math.PI / 2);
  const intakeGeo = new THREE.CircleGeometry(0.19, 30); intakeGeo.rotateY(Math.PI / 2);
  const pylonGeo = new THREE.BoxGeometry(0.34, 0.26, 0.07);
  [1, -1].forEach(side => {
    const eng = new THREE.Group();
    eng.position.set(0.22, -0.43, side * 1.02);
    eng.add(new THREE.Mesh(nacelleGeo, mats.body));
    const lip = new THREE.Mesh(lipGeo, mats.gold); lip.position.x = 0.32; eng.add(lip);
    const intake = new THREE.Mesh(intakeGeo, mats.dark); intake.position.x = 0.35; eng.add(intake);
    const pylon = new THREE.Mesh(pylonGeo, mats.wing); pylon.position.set(-0.02, 0.2, 0); eng.add(pylon);
    plane.add(eng);
  });

  /* tail */
  const fin = new THREE.Shape();
  fin.moveTo(-1.5, 0.12); fin.lineTo(-2.25, 1.05); fin.lineTo(-2.52, 1.05); fin.lineTo(-2.3, 0.12); fin.closePath();
  const finGeo = new THREE.ExtrudeGeometry(fin, { depth: 0.05, bevelEnabled: true, bevelThickness: 0.01, bevelSize: 0.012, bevelSegments: 1 });
  finGeo.translate(0, 0, -0.025);
  plane.add(new THREE.Mesh(finGeo, mats.gold));

  const stabGeo = wingGeometry(-1.82, -2.24, -2.3, -2.46, 0.9, 0.045);
  const stabR = new THREE.Mesh(stabGeo, mats.wing);
  stabR.position.set(0, 0.24, 0); stabR.rotation.x = 0.1;
  const stabL = stabR.clone(); stabL.scale.z = -1; stabL.rotation.x = -0.1;
  plane.add(stabR, stabL);

  return plane;
}

function makeMaterials() {
  const body = new THREE.MeshPhysicalMaterial({ color: 0xf7f8fb, roughness: 0.32, metalness: 0.04, clearcoat: 0.65, clearcoatRoughness: 0.22, envMapIntensity: 1.0, transparent: true });
  const wing = new THREE.MeshPhysicalMaterial({ color: 0xe6eaf2, roughness: 0.4, metalness: 0.08, clearcoat: 0.4, clearcoatRoughness: 0.3, envMapIntensity: 0.9, side: THREE.DoubleSide, transparent: true });
  const navy = new THREE.MeshPhysicalMaterial({ color: 0x14396f, roughness: 0.35, metalness: 0.1, clearcoat: 0.6, clearcoatRoughness: 0.2, envMapIntensity: 1.1, transparent: true });
  const gold = new THREE.MeshStandardMaterial({ color: 0xf5ad16, roughness: 0.3, metalness: 0.45, envMapIntensity: 1.2, side: THREE.DoubleSide, transparent: true });
  const dark = new THREE.MeshStandardMaterial({ color: 0x0b1626, roughness: 0.35, metalness: 0.3, envMapIntensity: 0.8, transparent: true });
  return { body, wing, navy, gold, dark, all: [body, wing, navy, gold, dark] };
}

/* --------------------------------------------------------------- trail --- */
class Trail {
  constructor(scene, color, width, max) {
    this.max = max; this.width = width; this.points = [];
    const g = new THREE.BufferGeometry();
    this.pos = new Float32Array(max * 2 * 3);
    this.alpha = new Float32Array(max * 2);
    const idx = [];
    for (let i = 0; i < max - 1; i++) { const a = i * 2; idx.push(a, a + 1, a + 2, a + 1, a + 3, a + 2); }
    g.setIndex(idx);
    g.setAttribute('position', new THREE.BufferAttribute(this.pos, 3));
    g.setAttribute('alpha', new THREE.BufferAttribute(this.alpha, 1));
    g.setDrawRange(0, 0);
    const mat = new THREE.ShaderMaterial({
      uniforms: { uColor: { value: new THREE.Color(color) } },
      vertexShader: 'attribute float alpha; varying float vA; void main(){ vA = alpha; gl_Position = projectionMatrix * modelViewMatrix * vec4(position,1.0); }',
      fragmentShader: 'uniform vec3 uColor; varying float vA; void main(){ gl_FragColor = vec4(uColor, vA); }',
      transparent: true, depthWrite: false, side: THREE.DoubleSide
    });
    this.mesh = new THREE.Mesh(g, mat);
    this.mesh.frustumCulled = false;
    this.mesh.renderOrder = -1;
    scene.add(this.mesh);
    this.last = null;
  }
  /* pagePos: world-space position with the page scroll folded in */
  push(pagePos, now, strength) {
    if (this.last && this.last.distanceTo(pagePos) < 0.035) return;
    this.last = pagePos.clone();
    this.points.unshift({ p: pagePos.clone(), t: now, s: strength });
    if (this.points.length > this.max) this.points.length = this.max;
  }
  update(now, scrollWorld, life) {
    const pts = this.points;
    while (pts.length && now - pts[pts.length - 1].t > life) pts.pop();
    const n = pts.length;
    if (n < 2) { this.mesh.geometry.setDrawRange(0, 0); return false; }
    for (let i = 0; i < n; i++) {
      const pt = pts[i];
      const age = (now - pt.t) / life;
      const t = i / (n - 1);
      const a = (1 - age) * (1 - age) * (1 - t * .55) * pt.s;
      const w = this.width * (0.35 + t * 1.35) * (1 - age * .35);
      const y = pt.p.y - scrollWorld;
      const o = i * 6;
      this.pos[o] = pt.p.x; this.pos[o + 1] = y + w; this.pos[o + 2] = pt.p.z;
      this.pos[o + 3] = pt.p.x; this.pos[o + 4] = y - w; this.pos[o + 5] = pt.p.z;
      this.alpha[i * 2] = a; this.alpha[i * 2 + 1] = a;
    }
    this.mesh.geometry.attributes.position.needsUpdate = true;
    this.mesh.geometry.attributes.alpha.needsUpdate = true;
    this.mesh.geometry.setDrawRange(0, (n - 1) * 6);
    return true;
  }
}

/* --------------------------------------------------------- waypoints --- */
/* fx/fy are fractions of the anchor element's box (or of the viewport when
   the key has no element). `at` is the fraction of the trigger element and
   `view` the fraction of the viewport that must line up to reach the key. */
/* After the hero the jet stays small and parks in each section's empty top
   padding band (`py` = px below the section top), travelling on a mostly
   vertical lane so it never crosses copy. */
function homeKeys() {
  return [
    { trig: '#hero', at: 0, view: 0, el: '#hero', fx: .85, fy: .33, s: .7, yaw: YAW_R, pitch: .04, roll: -.12, o: 1, m: { fx: .72, fy: .15, s: .42 } },
    { trig: '#hero', at: .55, view: 0, el: '#hero', fx: .84, fy: .96, s: .55, yaw: -.6, pitch: -.45, roll: -.3, o: 1, m: { fx: .8, fy: .96, s: .34 } },
    { trig: '#destinations', at: 0, view: .55, el: '#destinations', fx: .9, py: 44, s: .32, yaw: YAW_R, pitch: 0, roll: -.08, o: 1, m: { fx: .84, py: 30, s: .24 } },
    { trig: '.hgal__track', at: 0, view: 0, el: null, fx: .66, fy: .13, s: .3, yaw: YAW_R, pitch: .05, roll: -.1, o: 1, m: { fx: .84, py: 34, s: .24 } },
    { trig: '.hgal__track', at: 1, view: 1, el: null, fx: .94, fy: .125, s: .32, yaw: YAW_R, pitch: .06, roll: -.14, o: 1, m: { fx: .84, py: 34, s: .24 } },
    { trig: '#about', at: 0, view: .55, out: true, el: '#about .collage', fx: .55, fy: -.12, s: .36, yaw: YAW_R, pitch: 0, roll: -.1, o: 1, m: { fx: .5, fy: -.1, s: .26 } },
    { trig: '.services-section', at: 0, view: .55, out: true, el: '.services-section', fx: .86, py: 70, s: .34, yaw: YAW_R, pitch: 0, roll: -.1, o: 1, m: { fx: .84, py: 34, s: .24 } },
    { trig: '.why-us-section', at: 0, view: .55, out: true, el: '.why-us-section', fx: .5, py: 56, s: .32, yaw: YAW_R, pitch: 0, roll: -.1, o: 1, m: { fx: .2, py: 34, s: .22 } },
    { trig: '.media-section', at: 0, view: .55, out: true, el: '.media-section', fx: .5, py: 60, s: .32, yaw: YAW_R, pitch: 0, roll: -.1, o: 1, m: { fx: .2, py: 66, s: .2 } },
    { trig: '.testimonials-section', at: 0, view: .55, out: true, el: '.testimonials-section', fx: .9, py: 70, s: .32, yaw: YAW_R, pitch: 0, roll: -.1, o: 1, m: { fx: .84, py: 34, s: .24 } },
    { trig: '#enquiry', at: 0, view: .55, out: true, el: '#enquiry', fx: .9, py: 70, s: .32, yaw: YAW_R, pitch: .04, roll: -.1, o: 1, m: { fx: .84, py: 34, s: .24 } },
    { trig: '.site-footer', at: 0, view: .6, el: '.site-footer', fx: 1.15, fy: -.3, s: .24, yaw: YAW_R, pitch: .5, roll: -.3, o: 0, m: { fx: 1.15, fy: -.3, s: .18 } }
  ];
}
function innerKeys() {
  return [
    { trig: '.page-hero', at: 0, view: 0, el: '.page-hero', fx: .8, fy: .42, s: .72, yaw: YAW_R, pitch: .05, roll: -.12, o: 1, m: { fx: .78, fy: .2, s: .38 } },
    { trig: '.page-hero', at: 1, view: .15, el: '.page-hero', fx: 1.2, fy: -.3, s: .4, yaw: YAW_R, pitch: .55, roll: -.3, o: 0, m: { fx: 1.2, fy: -.3, s: .25 } }
  ];
}

/* ---------------------------------------------------------------- init --- */
function init() {
  if (reduced || !supportsWebGL()) { document.documentElement.classList.add('flight-fallback'); ready(); return; }
  const keysDef = document.querySelector('#hero') ? homeKeys() : document.querySelector('.page-hero') ? innerKeys() : null;
  if (!keysDef) { ready(); return; }

  const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true, powerPreference: 'high-performance' });
  renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, mobileMQ.matches ? 1.6 : 2));
  renderer.setClearColor(0x000000, 0);
  renderer.toneMapping = THREE.ACESFilmicToneMapping;
  renderer.toneMappingExposure = 1.02;
  renderer.domElement.className = 'flight-canvas';
  renderer.domElement.setAttribute('aria-hidden', 'true');
  document.body.appendChild(renderer.domElement);

  const scene = new THREE.Scene();
  scene.environment = makeEnvironment();
  const camera = new THREE.PerspectiveCamera(FOV, 1, 0.1, 100);
  camera.position.set(0, 0, CAM_Z);

  scene.add(new THREE.HemisphereLight(0xffffff, 0x6f7f99, 0.75));
  const key = new THREE.DirectionalLight(0xffffff, 2.1); key.position.set(4, 7, 6); scene.add(key);
  const fill = new THREE.DirectionalLight(0xbdd2ff, 0.55); fill.position.set(-6, 1, -2); scene.add(fill);
  const rim = new THREE.DirectionalLight(0xffd68a, 0.9); rim.position.set(-3, 4, 6); scene.add(rim);

  const mats = makeMaterials();
  const hero = buildPlane(mats);
  scene.add(hero);

  /* soft page shadow under the hero plane */
  const sc = document.createElement('canvas'); sc.width = 256; sc.height = 128;
  const sctx = sc.getContext('2d');
  const sg = sctx.createRadialGradient(128, 64, 4, 128, 64, 120);
  sg.addColorStop(0, 'rgba(6,23,43,.42)'); sg.addColorStop(.45, 'rgba(6,23,43,.16)'); sg.addColorStop(1, 'rgba(6,23,43,0)');
  sctx.scale(1, .5); sctx.fillStyle = sg; sctx.fillRect(0, 0, 256, 256);
  const shadowTex = new THREE.CanvasTexture(sc); shadowTex.colorSpace = THREE.SRGBColorSpace;
  const shadow = new THREE.Sprite(new THREE.SpriteMaterial({ map: shadowTex, transparent: true, depthWrite: false, opacity: 0 }));
  shadow.renderOrder = -2;
  scene.add(shadow);

  const trail = new Trail(scene, 0xcfd9ea, 0.07, 90);

  /* hero fleet (home only) */
  const fleet = [];
  const heroEl = document.querySelector('#hero');
  if (heroEl) {
    const fleetMats = makeMaterials();
    const proto = buildPlane(fleetMats);
    [
      { s: .12, y: .06, z: -1.5, speed: .9, delay: 0 },
      { s: .08, y: .13, z: -2.5, speed: .62, delay: 5 },
      { s: .1, y: .09, z: -2, speed: .75, delay: 10 }
    ].forEach(cfg => {
      const g = proto.clone();
      g.scale.setScalar(cfg.s);
      g.rotation.set(0, YAW_R + .12, -.05);
      scene.add(g);
      fleet.push({ g, cfg, x: 0, t: -cfg.delay, mats: fleetMats, trail: new Trail(scene, 0xffffff, 0.025, 60) });
    });
    fleet.forEach((f, i) => { f.x = -1.2 + i * .7; });
  }

  /* viewport maths */
  let vw = 1, vh = 1, visH = 1, visW = 1, wpp = 1;
  function resize() {
    vw = window.innerWidth; vh = window.innerHeight;
    renderer.setSize(vw, vh, false);
    camera.aspect = vw / vh; camera.updateProjectionMatrix();
    visH = 2 * CAM_Z * Math.tan(FOV * Math.PI / 360);
    visW = visH * camera.aspect;
    wpp = visH / vh;
    measure();
  }
  const toWorld = (sx, sy) => new THREE.Vector2((sx - vw / 2) * wpp, -(sy - vh / 2) * wpp);

  /* keys */
  const keys = keysDef.map(k => ({
    ...k,
    trigEl: document.querySelector(k.trig),
    anchor: k.el ? document.querySelector(k.el) : null,
    pos: 0
  })).filter(k => k.trigEl);
  function measure() {
    const sy = window.scrollY;
    keys.forEach(k => {
      const r = k.trigEl.getBoundingClientRect();
      k.pos = r.top + sy + r.height * k.at - vh * k.view;
    });
    keys.sort((a, b) => a.pos - b.pos);
  }
  function screenOf(k) {
    const mob = mobileMQ.matches && k.m;
    const src = mob ? k.m : k;
    const fx = src.fx, fy = src.fy, py = src.py;
    if (!k.anchor) return { x: vw * fx, y: py != null ? py : vh * fy };
    const r = k.anchor.getBoundingClientRect();
    return { x: r.left + r.width * fx, y: py != null ? r.top + py : r.top + r.height * fy };
  }
  function scaleOf(k) {
    const base = (mobileMQ.matches && k.m) ? k.m.s : k.s;
    return base * clamp(camera.aspect / 1.7, .72, 1.05);
  }
  function target(sy) {
    let i = 0;
    while (i < keys.length - 1 && sy > keys[i + 1].pos) i++;
    const a = keys[i], b = keys[Math.min(i + 1, keys.length - 1)];
    const u = a === b ? 0 : smooth((sy - a.pos) / Math.max(b.pos - a.pos, 1));
    const pa = screenOf(a), pb = screenOf(b);
    /* keys marked `out` are reached by leaving through the right edge and
       re-entering, so the jet never crosses the copy in between */
    const fly = b.out && a !== b ? Math.sin(u * Math.PI) : 0;
    return {
      x: lerp(pa.x, pb.x, u) + fly * vw * (mobileMQ.matches ? 1.15 : .6), y: lerp(pa.y, pb.y, u),
      s: lerp(scaleOf(a), scaleOf(b), u), yaw: lerp(a.yaw, b.yaw, u),
      pitch: lerp(a.pitch, b.pitch, u), roll: lerp(a.roll, b.roll, u) - fly * .2, o: lerp(a.o, b.o, u)
    };
  }

  /* state */
  const st = { x: -vw * .2, y: vh * .85, s: .25, yaw: -1.1, pitch: .3, roll: -.3, o: 1 };
  let revealed = false, revealAt = 0, lastScroll = window.scrollY, lastY = null;
  let mouseX = 0, mouseY = 0, mx = 0, my = 0;
  let running = true, last = performance.now(), t0 = last, idleFrames = 0;

  document.addEventListener('pointermove', e => {
    mouseX = (e.clientX / vw - .5) * 2; mouseY = (e.clientY / vh - .5) * 2;
  }, { passive: true });
  document.addEventListener('flight:reveal', () => { revealed = true; revealAt = performance.now(); });
  if (document.documentElement.classList.contains('is-revealed')) { revealed = true; revealAt = performance.now(); }
  document.addEventListener('visibilitychange', () => {
    running = !document.hidden;
    if (running) { last = performance.now(); requestAnimationFrame(frame); }
  });

  const tmp = new THREE.Vector3();
  function frame(now) {
    if (!running) return;
    const dt = Math.min((now - last) / 1000, .05); last = now;
    const time = (now - t0) / 1000;
    const sy = window.scrollY;
    const scrollWorld = sy * wpp;

    /* main plane follows its waypoint with a springy lag; the intro swoop
       is nothing more than a slower chase from off-screen. */
    const tg = target(sy);
    const intro = revealed && now - revealAt < 2200;
    const rate = !revealed ? 0 : intro ? 1.9 : 9;
    const f = 1 - Math.exp(-dt * rate);
    st.x = lerp(st.x, tg.x, f); st.y = lerp(st.y, tg.y, f); st.s = lerp(st.s, tg.s, f);
    st.yaw = lerp(st.yaw, tg.yaw, f); st.pitch = lerp(st.pitch, tg.pitch, f);
    st.roll = lerp(st.roll, tg.roll, f); st.o = lerp(st.o, tg.o, f);

    /* motion cues: scrolling pitches the nose; pointer banks the wings */
    const dScroll = clamp((sy - lastScroll) / Math.max(dt, .001) / 4000, -1, 1); lastScroll = sy;
    mx = lerp(mx, mouseX, 1 - Math.exp(-dt * 3)); my = lerp(my, mouseY, 1 - Math.exp(-dt * 3));

    const w = toWorld(st.x, st.y);
    const bob = (Math.sin(time * 1.25) * .05 + Math.sin(time * .53) * .03) * Math.min(st.s * 1.6, 1);
    hero.position.set(w.x, w.y + bob, 0);
    hero.rotation.set(
      st.pitch + Math.sin(time * .8) * .025 - my * .04 - dScroll * .1,
      st.yaw + mx * .06,
      st.roll + Math.sin(time * .95) * .035 + mx * .05
    );
    hero.scale.setScalar(Math.max(st.s, .001));
    hero.visible = st.o > .01;
    mats.all.forEach(mm => { mm.opacity = st.o; });

    shadow.position.set(w.x + st.s * .3, w.y - st.s * 2.3, -0.5);
    shadow.scale.set(st.s * 5.2, st.s * 2.4, 1);
    shadow.material.opacity = st.o * .55 * clamp(1 - Math.abs(hero.rotation.x) * 1.2, .2, 1);

    /* contrail emitted from the tail */
    let busy = false;
    if (hero.visible && revealed) {
      tmp.set(-2.3, .2, 0).applyEuler(hero.rotation).multiplyScalar(st.s).add(hero.position);
      tmp.y += scrollWorld;
      const moved = lastY == null ? 0 : Math.abs(tmp.y - lastY);
      lastY = tmp.y;
      trail.push(tmp, now, clamp(.35 + moved * 3 + Math.abs(dScroll), .35, .9) * st.o);
    }
    busy = trail.update(now, scrollWorld, 2600) || busy;

    /* the hero fleet drifts across the sky and fades as the hero leaves */
    if (fleet.length) {
      const hr = heroEl.getBoundingClientRect();
      const heroAlpha = clamp(1 - (-hr.top) / (hr.height * .85), 0, 1) * (revealed ? 1 : 0);
      fleet.forEach(fl => {
        fl.t += dt;
        if (fl.t < 0) { fl.g.visible = false; return; }
        fl.x += dt * fl.cfg.speed * .18;
        if (fl.x > 1.35) { fl.x = -1.3; fl.t = -2 - Math.random() * 3; fl.trail.points.length = 0; fl.trail.last = null; }
        const sx = vw * (fl.x * .5 + .5);
        const syp = hr.top + hr.height * fl.cfg.y + Math.sin(time * .6 + fl.cfg.z) * 14;
        const ww = toWorld(sx, syp);
        fl.g.position.set(ww.x, ww.y, fl.cfg.z);
        fl.g.rotation.set(Math.sin(time * .7 + fl.cfg.z) * .05, YAW_R + .15, -.06 + Math.sin(time * .5 + fl.cfg.z) * .05);
        fl.g.visible = heroAlpha > .02;
        fl.mats.all.forEach(mm => { mm.opacity = heroAlpha * .95; });
        if (fl.g.visible) {
          tmp.set(-2.3, .15, 0).applyEuler(fl.g.rotation).multiplyScalar(fl.cfg.s).add(fl.g.position);
          tmp.y += scrollWorld;
          fl.trail.push(tmp, now, .55 * heroAlpha);
        }
        busy = fl.trail.update(now, scrollWorld, 3600) || busy;
      });
    }

    const anythingVisible = hero.visible || busy || fleet.some(fl => fl.g.visible);
    if (anythingVisible) { renderer.render(scene, camera); idleFrames = 0; }
    else if (idleFrames++ < 2) renderer.render(scene, camera);
    requestAnimationFrame(frame);
  }

  window.addEventListener('resize', resize, { passive: true });
  window.addEventListener('load', measure);
  if ('ResizeObserver' in window) new ResizeObserver(measure).observe(document.body);
  resize();
  renderer.compile(scene, camera);
  requestAnimationFrame(frame);
  ready();
}

function ready() {
  window.__flightReady = true;
  document.dispatchEvent(new CustomEvent('flight:ready'));
}

try { init(); } catch (e) { console.warn('flight scene unavailable', e); document.documentElement.classList.add('flight-fallback'); ready(); }
