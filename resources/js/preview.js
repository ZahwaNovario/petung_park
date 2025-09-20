// resources/js/preview.js
import Marzipano from "marzipano";

document.addEventListener("DOMContentLoaded", () => {
    const panoEl = document.getElementById("pano");
    const inputEl = document.getElementById("fileInput");
    const addBtn = document.getElementById("addConnectionBtn");
    const listEl = document.getElementById("connectionList");
    const hiddenInput = document.getElementById("connectionsInput");

    if (!panoEl || !inputEl || !hiddenInput) return; // guard

    let viewer = new Marzipano.Viewer(panoEl);
    let scene = null;
    let addMode = false;
    let connections = [];
    let scenes = []; // semua scene yang pernah diupload

    if (window.currentScene && window.currentScene.image_path) {

        const source = Marzipano.ImageUrlSource.fromString("/" + window.currentScene.image_path);
        const geometry = new Marzipano.EquirectGeometry([{ width: 4000 }]);
        const view = new Marzipano.RectilinearView();
        scene = viewer.createScene({ source, geometry, view, pinFirstLevel: true });
        scene.switchTo();

        viewer.updateSize();
        requestAnimationFrame(() => viewer.updateSize()); // jaga-jaga setelah layout settle

        // update kalau ukuran container berubah
        window.addEventListener("resize", () => viewer.updateSize());

        // atau lebih presisi:
        new ResizeObserver(() => viewer.updateSize()).observe(panoEl);

        // render existing connections
        connections = (window.existingConnections || []).map(conn => {
            const el = document.createElement("div");
            el.classList.add("hotspot-point");
            el.innerHTML = "📍";
            scene.hotspotContainer().createHotspot(el, { yaw: conn.yaw, pitch: conn.pitch });

            return {
                yaw: conn.yaw,
                pitch: conn.pitch,
                target: conn.target,
                el
            };
        });
        renderList();

    }

    // Preview image → bikin scene baru
    inputEl.addEventListener("change", (e) => {
        const file = e.target.files[0];
        if (!file) return;

        const url = URL.createObjectURL(file);

        panoEl.innerHTML = "";
        viewer = new Marzipano.Viewer(panoEl);

        const source = Marzipano.ImageUrlSource.fromString(url);
        const geometry = new Marzipano.EquirectGeometry([{ width: 4000 }]);
        const limiter = Marzipano.RectilinearView.limit.traditional(
            1024,
            100 * Math.PI / 180
        );
        const view = new Marzipano.RectilinearView(null, limiter);

        scene = viewer.createScene({
            source,
            geometry,
            view,
            pinFirstLevel: true,
        });

        const sceneName = file.name.replace(/\.[^/.]+$/, ""); // tanpa ekstensi
        scenes.push({ name: sceneName, scene });

        scene.switchTo();
        viewer.updateSize();
        requestAnimationFrame(() => viewer.updateSize());
        connections = [];
        renderList();
    });

    // Tombol tambah connection
    addBtn?.addEventListener("click", () => {
        if (!scene) return;
        addMode = true;
        addBtn.textContent = "Click a point on panorama...";
        addBtn.disabled = true;
    });

    // Klik panorama untuk tambah hotspot
    panoEl.addEventListener("click", (e) => {
        if (!addMode || !scene) return;

        const view = scene.view();
        const rect = panoEl.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        const coords = view.screenToCoordinates({ x, y });
        if (!coords) return;

        const yaw = parseFloat(coords.yaw.toFixed(3));
        const pitch = parseFloat(coords.pitch.toFixed(3));

        // hotspot element
        const el = document.createElement("div");
        el.classList.add("hotspot-point");
        el.innerHTML = "📍";

        scene.hotspotContainer().createHotspot(el, { yaw, pitch });

        // Auto assign target default = first scene (jika ada)
        let defaultTarget = window.allScenes.length > 0 ? window.allScenes[0].id : null;

        connections.push({ yaw, pitch, el, target: defaultTarget });
        renderList();

        console.log("Captured:", { yaw, pitch, target: defaultTarget });

        addMode = false;
        addBtn.textContent = "+ Add Connection";
        addBtn.disabled = false;
    });

    // Sync connections ke hidden input
    function syncConnectionsInput() {
        hiddenInput.value = JSON.stringify(
            connections.map(c => ({
                yaw: c.yaw,
                pitch: c.pitch,
                target: c.target
            }))
        );
    }

    // Render ulang list koneksi
    function renderList() {
        if (!listEl) return;
        listEl.innerHTML = "";

        connections.forEach((c, i) => {
            const li = document.createElement("li");
            li.style.marginBottom = "6px";

            const text = document.createElement("span");
            text.textContent = `#${i + 1} → yaw: ${c.yaw}, pitch: ${c.pitch}`;

            // dropdown pilih scene tujuan
            const select = document.createElement("select");
            select.style.marginLeft = "10px";

            window.allScenes.forEach(s => {
                const opt = document.createElement("option");
                opt.value = s.id;
                opt.textContent = s.name;
                select.appendChild(opt);
            });

            if (c.target == null && window.allScenes.length > 0) {
                c.target = String(window.allScenes[0].id);
            } else {
                c.target = String(c.target);
            }

            // validasi: kalau tidak ada di allScenes, fallback
            const valid = window.allScenes.some(s => String(s.id) === c.target);
            if (!valid && window.allScenes.length > 0) {
                c.target = String(window.allScenes[0].id);
            }

            select.value = String(c.target);


            console.log("Target:", c.target, "Options:", [...select.options].map(o => o.value));

            select.addEventListener("change", () => {
                c.target = String(select.value);
                syncConnectionsInput();
            });



            // tombol hapus hotspot
            const removeBtn = document.createElement("button");
            removeBtn.textContent = "❌";
            removeBtn.style.marginLeft = "10px";
            removeBtn.style.padding = "2px 6px";
            removeBtn.style.fontSize = "12px";
            removeBtn.style.cursor = "pointer";

            removeBtn.addEventListener("click", () => {
                c.el?.remove();
                connections.splice(i, 1);
                renderList();
            });

            li.appendChild(text);
            li.appendChild(select);
            li.appendChild(removeBtn);
            listEl.appendChild(li);
        });

        syncConnectionsInput();
    }
});
// setelah DOMContentLoaded


