let wpopups = {
    hide: () => {
        document.body.classList.remove("disable-scroll");
        document.querySelectorAll(".w-popups .w-popup").forEach(popup => {
            popup.classList.remove("show");
        });
        document.querySelector(".w-popups").classList.remove("show");
    },
    show: (id) => {
        document.body.classList.add("disable-scroll");
        document.querySelectorAll(".w-popups .w-popup").forEach(popup => {
            popup.classList.remove("show");
        });
        document.querySelector(".w-popups").classList.add("show");
        document.querySelectorAll(`.w-popups .w-popup[popup-id="${id}"]`).forEach(popup => {
            popup.classList.add("show");
        });
    },
    get: (id) => {
        return id ? document.querySelector(`.w-popups .w-popup[popup-id="${id}"]`) : document.querySelectorAll(".w-popups .w-popup");
    }
}