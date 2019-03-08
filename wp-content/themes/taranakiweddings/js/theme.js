jQuery(function($) {
    var $ = jQuery;
    $('.down').click(function(event){
        if($(window).width() > 575)
        {
            $('html, body').animate({
                scrollTop: $('[name="content-start"]').offset().top - 70
            }, 500);
            event.preventDefault();
        } else {
            $('html, body').animate({
                scrollTop: $('[name="content-start"]').offset().top - 25
            }, 500);
            event.preventDefault();
        }
    });
    if ($(window).width() > 767) {
        var waypoint = new Waypoint({
            element: document.getElementById('content'),
            handler: function () {
                $("#header").toggleClass('shrink');
            },
            offset: -5
        });
    }
    gallerySlick = $(".gallery-wrapper").slick({
        dots:false,
        speed: 300,
        slidesToShow: 1,
        infinite: true,
        arrows: true,
        centerMode: true,
        variableWidth: true
    });
    blogSlick = $(".blog-large-image-wrapper").slick({
        dots:false,
        speed: 300,
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: true,
        arrows: true
    });
});
function addListing(id) {
    var $ = jQuery;
    $.ajax({
        url: "?ajax=add_listing&listingid=" + id,
        cache: false,
        success: function (response) {
            var arr = response.split('|');
            $(".like-id-"+id).html(arr[0]).hide().fadeIn();

            $(".shortlist-link").html(arr[1]);
        }
    });
}
function removeListing(id) {
    var $ = jQuery;
    $.ajax({
        url: "?ajax=remove_listing&listingid=" + id,
        cache: false,
        success: function (response) {
            var arr = response.split('|');
            $(".like-id-"+id).html(arr[0]).hide().fadeIn();

            $(".shortlist-link").html(arr[1]);
        }
    });
}
function removeFromList(id) {
    var $ = jQuery;
    $.ajax({
        url: "?ajax=remove_from_list&listingid=" + id,
        cache: false,
        success: function (response) {

        }
    });
}