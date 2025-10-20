import Marzipano from "marzipano";

document.addEventListener("DOMContentLoaded", () => {
    const customSelect = document.getElementById("custom-resolution-select");
    const hiddenSelect = document.getElementById("resolution-select");

    if (customSelect && hiddenSelect) {
        const selectedBox = customSelect.querySelector(".select-selected");
        const itemsContainer = customSelect.querySelector(".select-items");
        const options = itemsContainer.querySelectorAll("div");

        selectedBox.addEventListener("click", function (e) {
            e.stopPropagation();
            itemsContainer.classList.toggle("select-hide");
            this.classList.toggle("select-arrow-active");
        });

        options.forEach((option) => {
            option.addEventListener("click", function () {
                selectedBox.textContent = this.textContent;
                hiddenSelect.value = this.getAttribute("data-value");
                hiddenSelect.dispatchEvent(new Event("change"));
                itemsContainer.classList.add("select-hide");
                selectedBox.classList.remove("select-arrow-active");
            });
        });

        document.addEventListener("click", function () {
            itemsContainer.classList.add("select-hide");
            selectedBox.classList.remove("select-arrow-active");
        });
    }

    const panoEl = document.getElementById("pano");
    const captionEl = document.getElementById("caption");
    const resSelect = document.getElementById("resolution-select");
    const loadingOverlay = document.getElementById("loading-overlay");

    if (!panoEl) return;

    const parsedData = JSON.parse(document.getElementById("scene-data").textContent);
    let currentSceneId = parsedData.activeSceneId;
    const sceneDataList = parsedData.scenes;

    const viewer = new Marzipano.Viewer(panoEl, {
        controls: { mouseViewMode: "drag" },
    });

    const marzipanoScenes = {};
    let currentRes = "low"; // default resolusi

    // Event listener dropdown resolusi
    if (resSelect) {
        resSelect.addEventListener("change", (e) => {
            currentRes = e.target.value;
            if (marzipanoScenes[currentSceneId]) {
                switchScene(currentSceneId);
            }
        });
    }

    // Buat semua scene
    sceneDataList.forEach((sceneData) => {
        const createScene = (res) => {
            const currentPath = sceneData.imagePath;

            let newImagePath = currentPath
                .replace(/\/(low|medium|high|original|\d+)\//, `/${res}/`)
                .replace(/_(low|medium|high|original|\d+)\.jpg/, `_${res}.jpg`);

            console.log("Generated Image Path:", newImagePath);

            const source = Marzipano.ImageUrlSource.fromString(newImagePath);
            const geometry = new Marzipano.EquirectGeometry([{ width: 4000 }]);
            const limiter = Marzipano.RectilinearView.limit.traditional(
                4096,
                (120 * Math.PI) / 180
            );
            const view = new Marzipano.RectilinearView(null, limiter);

            const scene = viewer.createScene({
                source,
                geometry,
                view,
                pinFirstLevel: true,
            });

            (sceneData.hotspots || []).forEach((hs) => {
                const el = document.createElement("div");
                el.classList.add("hotspot-arrow");
                el.textContent = "⮝";
                el.style.cursor = "pointer";
                el.onclick = () => switchScene(hs.targetScene);
                scene.hotspotContainer().createHotspot(el, { yaw: hs.yaw, pitch: hs.pitch });
            });

            return { scene, view };
        };

        marzipanoScenes[sceneData.id] = {
            createScene,
            caption: sceneData.caption,
        };
    });

    // Fungsi loading
    function showLoading() {
        const loader = document.getElementById("loading-overlay");
        if (loader) {
            loader.classList.add("show");
        }
    }

    function hideLoading() {
        const loader = document.getElementById("loading-overlay");
        if (loader) {
            loader.classList.remove("show");
            setTimeout(() => (loader.style.display = "none"), 400);
        }
    }

    // Fungsi ganti scene
    function switchScene(id) {
        const sceneObj = marzipanoScenes[id];

        if (!sceneObj) {
            const anySceneExists = Object.keys(marzipanoScenes).length > 0;
            if (anySceneExists) {
                window.location.href = `/virtual-tour/show-scene/${id}`;
            } else {
                renderPlaceholder();
            }
            return;
        }

        showLoading();

        const { scene, view } = sceneObj.createScene(currentRes);

        scene.addEventListener(
            "renderComplete",
            () => {
                console.log("✅ Scene render complete");
                hideLoading();
            },
            { once: true }
        );

        setTimeout(() => {
            hideLoading();
        }, 2000);

        scene.switchTo();
        currentSceneId = id;

        if (captionEl) captionEl.textContent = sceneObj.caption || "";

        view.setYaw(Math.PI);
    }

    // Load awal
    if (marzipanoScenes[currentSceneId]) {
        switchScene(currentSceneId);
    }

    // Klik tombol panel kiri
    document.querySelectorAll("#panel button").forEach((btn) => {
        btn.addEventListener("click", () => {
            const targetId = parseInt(btn.getAttribute("data-scene"), 10);
            switchScene(targetId);
        });
    });

    // Placeholder function if no scene is found
    function renderPlaceholder() {
        panoEl.innerHTML = "<div class='placeholder'>Scene tidak ditemukan</div>";
    }
});
