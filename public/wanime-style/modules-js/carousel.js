let wCarousel;
let wCarouselActiveItem = 1;
let wCarouselItemCount;
let wCarouselSlideInterval;
let wCarouselSlideInteruptTimeout;
let wCarouselSlideWait = false;

document.addEventListener('DOMContentLoaded', () => {
    wCarousel = document.querySelector(".w-carousel");

    wCarouselItemCount = wCarousel.querySelectorAll(".items .item").length;

    wCarouselSlideInterval = setInterval(wCarouselSlideNext, 5000);

});

function wCarouselSlideNext() {
    
    if (wCarouselSlideWait) return;

    clearInterval(wCarouselSlideInterval);
    wCarouselSlideInterval = setInterval(wCarouselSlideNext, 5000);

    $(wCarousel).find(".item").removeClass("slide-active");
    $(wCarousel).find(".item").removeClass("slide-next");
    $(wCarousel).find(".item").removeClass("slide-next-2");
    $(wCarousel).find(".item").removeClass("slide-prev");
    $(wCarousel).find(".item").removeClass("slide-prev-2");

    if (wCarouselActiveItem < wCarouselItemCount) {
        wCarouselActiveItem++;

        if (wCarouselActiveItem - 2 >= 0) wCarousel.querySelectorAll(".items .item")[wCarouselActiveItem - 2].classList.add("slide-prev");
        else wCarousel.querySelectorAll(".items .item")[wCarouselItemCount - 1].classList.add("slide-prev");
        
        wCarousel.querySelectorAll(".items .item")[wCarouselActiveItem - 1].classList.add("slide-active");

        if (wCarouselActiveItem < wCarouselItemCount) wCarousel.querySelectorAll(".items .item")[wCarouselActiveItem].classList.add("slide-next");
        else wCarousel.querySelectorAll(".items .item")[0].classList.add("slide-next");
        
    } else {
        wCarouselActiveItem = 1;

        if (wCarouselActiveItem - 2 >= 0) wCarousel.querySelectorAll(".items .item")[wCarouselActiveItem - 2].classList.add("slide-prev");
        else wCarousel.querySelectorAll(".items .item")[wCarouselItemCount - 1].classList.add("slide-prev");
        
        wCarousel.querySelectorAll(".items .item")[wCarouselActiveItem - 1].classList.add("slide-active");

        if (wCarouselActiveItem < wCarouselItemCount) wCarousel.querySelectorAll(".items .item")[wCarouselActiveItem].classList.add("slide-next");
        else wCarousel.querySelectorAll(".items .item")[0].classList.add("slide-next");
    }

    wCarouselSlideWait = true;
    setTimeout(() => wCarouselSlideWait = false, 1000);
}

function wCarouselSlidePrev() {
    if (wCarouselSlideWait) return;

    clearInterval(wCarouselSlideInterval);
    wCarouselSlideInterval = setInterval(wCarouselSlideNext, 5000);

    $(wCarousel).find(".item").removeClass("slide-active");
    $(wCarousel).find(".item").removeClass("slide-next");
    $(wCarousel).find(".item").removeClass("slide-next-2");
    $(wCarousel).find(".item").removeClass("slide-prev");
    $(wCarousel).find(".item").removeClass("slide-prev-2");

    if (wCarouselActiveItem > 1) {
        wCarouselActiveItem--;

        if (wCarouselActiveItem - 2 >= 0) wCarousel.querySelectorAll(".items .item")[wCarouselActiveItem - 2].classList.add("slide-prev-2");
        else wCarousel.querySelectorAll(".items .item")[wCarouselItemCount - 1].classList.add("slide-prev-2");
        
        wCarousel.querySelectorAll(".items .item")[wCarouselActiveItem - 1].classList.add("slide-active");

        if (wCarouselActiveItem < wCarouselItemCount) wCarousel.querySelectorAll(".items .item")[wCarouselActiveItem].classList.add("slide-next-2");
        else wCarousel.querySelectorAll(".items .item")[0].classList.add("slide-next-2");
        
    } else {
        wCarouselActiveItem = wCarouselItemCount;

        if (wCarouselActiveItem - 2 >= 0) wCarousel.querySelectorAll(".items .item")[wCarouselActiveItem - 2].classList.add("slide-prev-2");
        else wCarousel.querySelectorAll(".items .item")[wCarouselItemCount - 1].classList.add("slide-prev-2");
        
        wCarousel.querySelectorAll(".items .item")[wCarouselActiveItem - 1].classList.add("slide-active");

        if (wCarouselActiveItem < wCarouselItemCount) wCarousel.querySelectorAll(".items .item")[wCarouselActiveItem].classList.add("slide-next-2");
        else wCarousel.querySelectorAll(".items .item")[0].classList.add("slide-next-2");
    }

    wCarouselSlideWait = true;
    setTimeout(() => wCarouselSlideWait = false, 1000);
}