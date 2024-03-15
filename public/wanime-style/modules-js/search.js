let search = {
    show: () => {document.querySelector(".search-dropdown").classList.add("show"); toggleAccountDropdown("close");},
    hide: () => document.querySelector(".search-dropdown").classList.remove("show"),
    toggle: () => {
        let dropdown = document.querySelector(".search-dropdown");

        if (dropdown.classList.contains("show")) dropdown.classList.remove("show");
        else {dropdown.classList.add("show"); toggleAccountDropdown("close");}
    }
}