import Marzipano from 'marzipano';

document.addEventListener("DOMContentLoaded", () => {
    const panoEl = document.getElementById('pano');
    const captionEl = document.getElementById('caption');
    if (!panoEl) return;

    const parsedData = JSON.parse(document.getElementById('scene-data').textContent);
    const currentSceneId = parsedData.activeSceneId;
    const sceneDataList = parsedData.scenes;

    const viewer = new Marzipano.Viewer(panoEl);
    const marzipanoScenes = {};

    // Kalau tidak ada scene sama sekali → tampilkan placeholder
    if (sceneDataList.length === 0) {
        panoEl.innerHTML = `
                <div style="
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    height:100%;
                    width:100%;
                    background:#333;
                    color:#fff;
                    font-size:24px;
                    font-weight:600;
                    text-align:center;
                ">
                    Virtual Tour Coming Soon
                </div>
            `;
        return;
    }


    // Buat semua scene dari data database
    sceneDataList.forEach(sceneData => {
        // Gunakan placeholder jika imagePath kosong/null
        const imagePath = sceneData.imagePath && sceneData.imagePath.trim() !== ""
            ? sceneData.imagePath
            : "https://via.placeholder.com/1000x563?text=Virtual+Tour+Coming+Soon";

        const source = Marzipano.ImageUrlSource.fromString(imagePath);
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
            window.location.href = `/virtual-tour/show-scene/${id}`;
        }
    }

    // Set scene awal
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
