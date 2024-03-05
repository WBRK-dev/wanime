document.addEventListener('DOMContentLoaded', () => {
    $(".watchlist-dropdown button").click(function() {
        let dropdown = $(this).parent().children(".dropdown");
        if ($(dropdown).hasClass("show")) $(dropdown).removeClass("show");
        else $(dropdown).addClass("show");
    });

    $(".watchlist-dropdown .dropdown button.dropdown-item").click(function() {

        $(this).parent().children(".dropdown-item").removeClass("active");

        if ($(this).attr("data-dropdown-type") !== "remove") {
            $(this).addClass("active");
            $(this).parent().parent().children("button").children("span").text($(this).text());
        } else {
            $(this).parent().parent().children("button").children("span").text("WatchList");
        }

        watchlistStatusUpdate($(this).text().toLowerCase());

        $(this).parent().removeClass("show");
    });
});