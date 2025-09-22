import Marzipano from 'marzipano';

document.addEventListener("DOMContentLoaded", () => {
    const panoEl = document.getElementById('pano');
    const captionEl = document.getElementById('caption');
    if (!panoEl) return;

    // Ambil data dari atribut HTML yang di-pass Blade
    const parsedData = JSON.parse(document.getElementById('scene-data').textContent);
    const currentSceneId = parsedData.activeSceneId;
    const sceneDataList = parsedData.scenes;

    const viewer = new Marzipano.Viewer(panoEl);
    const marzipanoScenes = {};

    // Buat semua scene dari data database
    sceneDataList.forEach(sceneData => {
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

        // Tambah hotspot
        sceneData.hotspots.forEach(hs => {
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
            // Kalau scene target masih dalam lokasi ini → langsung switch
            marzipanoScenes[id].scene.switchTo();
            if (captionEl) {
                captionEl.textContent = marzipanoScenes[id].caption || "";
            }
        } else {
            // Kalau nggak ada di current JSON → berarti beda lokasi → reload ke scene.show
            window.location.href = `/scene/${id}`;
        }
    }
    // Ambil scene id yang aktif dari Blade


    // Set scene awal pakai id dari route, bukan [0]
    // Set scene awal pakai id dari route
    if (marzipanoScenes[currentSceneId]) {
        switchScene(currentSceneId);
    } else if (sceneDataList.length > 0) {
        switchScene(sceneDataList[0].id);
    }



    // Klik panel
    document.querySelectorAll('#panel button').forEach(btn => {
        btn.addEventListener('click', () => {
            const targetId = parseInt(btn.getAttribute('data-scene'), 10);
            switchScene(targetId);
        });
    });
});
