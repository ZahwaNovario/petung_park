import Marzipano from 'marzipano';

document.addEventListener("DOMContentLoaded", () => {
  (async function init() {
    const panoEl = document.getElementById('pano');
    const captionEl = document.getElementById('caption');
    if (!panoEl) return;

    const parsedData = JSON.parse(document.getElementById('scene-data').textContent);
    const currentSceneId = parsedData.activeSceneId;
    const sceneDataList = parsedData.scenes || [];

    const viewer = new Marzipano.Viewer(panoEl);
    const marzipanoScenes = {};

    // --- Helper ---
    function renderPlaceholder() {
      panoEl.innerHTML = `
        <div style="
          display:flex;align-items:center;justify-content:center;
          height:100%;width:100%;
          background:#333;color:#fff;font-size:24px;font-weight:600;text-align:center;">
          Virtual Tour is under maintenance
        </div>`;
    }

    async function urlExists(url) {
      try {
        const res = await fetch(url, { method: 'HEAD', cache: 'no-store' });
        return res.ok; // true kalau 2xx
      } catch (e) {
        return false;
      }
    }

    // --- Kalau tidak ada scene sama sekali ---
    if (sceneDataList.length === 0) {
      renderPlaceholder();
      return;
    }

    // Validasi semua imagePath: kalau 404 → jadikan null (biar di-skip)
    const validatedScenes = await Promise.all(
      sceneDataList.map(async (s) => {
        const path = (s.imagePath || '').trim();
        if (!path) return { ...s, _validImage: false };
        const ok = await urlExists(path);
        return { ...s, _validImage: ok };
      })
    );

    // Buat scene hanya untuk yang gambarnya valid
    validatedScenes.forEach(sceneData => {
      if (!sceneData._validImage) return; // skip scene yang gambarnya gak ada

      const source = Marzipano.ImageUrlSource.fromString(sceneData.imagePath);
      const geometry = new Marzipano.EquirectGeometry([{ width: 3000 }]);
      const limiter = Marzipano.RectilinearView.limit.traditional(50000, 100 * Math.PI / 180);
      const view = new Marzipano.RectilinearView(null, limiter);

      const scene = viewer.createScene({
        source: source,
        geometry: geometry,
        view: view,
        pinFirstLevel: true
      });

      // Hotspots
      (sceneData.hotspots || []).forEach(hs => {
        const el = document.createElement('div');
        el.classList.add('hotspot-arrow');
        el.innerHTML = "⮝";
        el.style.cursor = "pointer";
        el.onclick = () => switchScene(hs.targetScene);
        scene.hotspotContainer().createHotspot(el, { yaw: hs.yaw, pitch: hs.pitch });
      });

      marzipanoScenes[sceneData.id] = { scene, caption: sceneData.caption };
    });

    function switchScene(id) {
      if (marzipanoScenes[id]) {
        marzipanoScenes[id].scene.switchTo();
        if (captionEl) {
          captionEl.textContent = marzipanoScenes[id].caption || "";
        }
      } else {
        // kalau id target tidak ada scene valid di lokasi ini → coba ke backend
        // (kalau ID ini memang beda lokasi) atau tampilkan placeholder
        // Di sini kita pilih: jika *benar-benar* tidak ada scene valid sama sekali → placeholder
        const anySceneExists = Object.keys(marzipanoScenes).length > 0;
        if (anySceneExists) {
          // id tidak ada di cache scene saat ini → kemungkinan beda lokasi
          window.location.href = `/virtual-tour/show-scene/${id}`;
        } else {
          renderPlaceholder();
        }
      }
    }

    // Set scene awal:
    if (marzipanoScenes[currentSceneId]) {
      switchScene(currentSceneId);
    } else {
      // cari scene valid pertama
      const firstValid = validatedScenes.find(s => s._validImage);
      if (firstValid && marzipanoScenes[firstValid.id]) {
        switchScene(firstValid.id);
      } else {
        renderPlaceholder();
      }
    }

    // Klik panel
    document.querySelectorAll('#panel button').forEach(btn => {
      btn.addEventListener('click', () => {
        const targetId = parseInt(btn.getAttribute('data-scene'), 10);
        switchScene(targetId);
      });
    });
  })();
});
