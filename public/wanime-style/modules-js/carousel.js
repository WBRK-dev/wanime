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

    $(wCarousel).children(".items").children(".item").removeClass("slide-active");
    $(wCarousel).children(".items").children(".item").removeClass("slide-next");
    $(wCarousel).children(".items").children(".item").removeClass("slide-prev");

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

// function wCarouselSlidePrev() {
//     if (wCarouselSlideWait) return;

//     clearInterval(wCarouselSlideInterval);
//     wCarouselSlideInterval = setInterval(wCarouselSlideNext, 5000);

//     $(wCarousel).children(".items").children(".item").removeClass("slide-active");
//     $(wCarousel).children(".items").children(".item").removeClass("slide-next");
//     $(wCarousel).children(".items").children(".item").removeClass("slide-prev");

//     if (wCarouselActiveItem > 1) {
//         wCarouselActiveItem--;

//         if (wCarouselActiveItem - 2 >= 0) wCarousel.querySelectorAll(".items .item")[wCarouselActiveItem - 2].classList.add("slide-prev");
//         else wCarousel.querySelectorAll(".items .item")[wCarouselItemCount - 1].classList.add("slide-prev");
        
//         wCarousel.querySelectorAll(".items .item")[wCarouselActiveItem - 1].classList.add("slide-active");

//         if (wCarouselActiveItem < wCarouselItemCount) wCarousel.querySelectorAll(".items .item")[wCarouselActiveItem].classList.add("slide-next");
//         else wCarousel.querySelectorAll(".items .item")[0].classList.add("slide-next");
        
//     } else {
//         wCarouselActiveItem = wCarouselItemCount;

//         if (wCarouselActiveItem - 2 >= 0) wCarousel.querySelectorAll(".items .item")[wCarouselActiveItem - 2].classList.add("slide-prev");
//         else wCarousel.querySelectorAll(".items .item")[wCarouselItemCount - 1].classList.add("slide-prev");
        
//         wCarousel.querySelectorAll(".items .item")[wCarouselActiveItem - 1].classList.add("slide-active");

//         if (wCarouselActiveItem < wCarouselItemCount) wCarousel.querySelectorAll(".items .item")[wCarouselActiveItem].classList.add("slide-next");
//         else wCarousel.querySelectorAll(".items .item")[0].classList.add("slide-next");
//     }

//     wCarouselSlideWait = true;
//     setTimeout(() => wCarouselSlideWait = false, 1000);
// }