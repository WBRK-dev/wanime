let accountDropdown;

document.addEventListener('DOMContentLoaded', () => accountDropdown = document.querySelector(".account-dropdown"));

function toggleAccountDropdown(mode) {
    if (mode === "open") {
        accountDropdown.classList.add("show");
        search.hide();
    } else if (mode === "close") {
        accountDropdown.classList.remove("show");
    } else if (accountDropdown.classList.contains("show")) {
        accountDropdown.classList.remove("show");
    } else {
        accountDropdown.classList.add("show");
        search.hide();
    }
}