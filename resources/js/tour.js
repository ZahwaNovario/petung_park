import Marzipano from 'marzipano';

document.addEventListener("DOMContentLoaded", () => {
    const panoEl = document.getElementById('pano');
    const captionEl = document.getElementById('caption');
    if (!panoEl) return;

    // Data semua scene
    const sceneDataList = [
        {
            id: 1,
            name: "Ruang Makan",
            caption: "Ini adalah ruang makan.",
            imagePath: "/images/example.jpg",
            hotspots: [
                { yaw: 5, pitch: 0, targetScene: 2 }
            ]
        },
        {
            id: 2,
            name: "Outdoor",
            caption: "Ini adalah area outdoor.",
            imagePath: "/images/example2.jpg",
            hotspots: [
                { yaw: Math.PI, pitch: 0, targetScene: 1 }
            ]
        }
    ];

    // Buat viewer
    const viewer = new Marzipano.Viewer(panoEl);
    const marzipanoScenes = {};

    // Buat semua scene
    sceneDataList.forEach(sceneData => {
        const source = Marzipano.ImageUrlSource.fromString(sceneData.imagePath);
        const geometry = new Marzipano.EquirectGeometry([{ width: 3000 }]);
        const limiter = Marzipano.RectilinearView.limit.traditional(1024, 100 * Math.PI / 180);
        const view = new Marzipano.RectilinearView(null, limiter);

        const scene = viewer.createScene({
            source: source,
            geometry: geometry,
            view: view,
            pinFirstLevel: true
        });

        // Tambah hotspot panah
        sceneData.hotspots.forEach(hs => {
            const el = document.createElement('div');
            el.classList.add('hotspot-arrow');
            el.innerHTML = "➡";
            el.style.cursor = "pointer";
            el.onclick = () => switchScene(hs.targetScene);

            scene.hotspotContainer().createHotspot(el, { yaw: hs.yaw, pitch: hs.pitch });
        });

        // Simpan ke object
        marzipanoScenes[sceneData.id] = { scene, caption: sceneData.caption };
    });

    // Fungsi ganti scene
    function switchScene(id) {
        if (marzipanoScenes[id]) {
            marzipanoScenes[id].scene.switchTo();
            if (captionEl) {
                captionEl.textContent = marzipanoScenes[id].caption || "";
            }
        }
    }

    // Panel klik
    document.querySelectorAll('#panel button').forEach(btn => {
        btn.addEventListener('click', () => {
            const targetId = parseInt(btn.getAttribute('data-scene'), 10);
            switchScene(targetId);
        });
    });

    // Expose switchScene ke global biar bisa dipanggil script lain (optional)
    window.switchScene = switchScene;
});
