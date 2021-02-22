/**
 * Created by user on 10/19/2016.
 */
$(window).on("load", function() {
    $('#cover').delay(500).fadeOut(1000).hide(function () {
        $("html, body").delay(1000).animate({
            scrollTop: 980
        }, 2200);
        $('#mv_logo, #mv_credit').delay(3000).fadeIn(800)
        $('#mv_rin').delay(3500).animate({opacity: "1"}, 1000);
        $('#header').delay(4000).slideDown(800);
    });
});

$(document).ready(function() {
    $('#pengenalan').click(function () {
        $("html, body").animate({
            scrollTop: 1700
        }, 1500);
    });

    $('#Hasil').click(function () {
        $("html, body").animate({
            scrollTop: 2400
        }, 1500);
    });

    $('#hitung').click(function () {
        $("html, body").animate({
            scrollTop: 3100
        }, 1500);
    });

    $('#tambah').click(function () {
        $("html, body").animate({
            scrollTop: 3800
        }, 1500);
    });

    $('#scroll_top').click(function () {
        $("html, body").animate({
            scrollTop: 980
        }, 1500);
    });

    //Check to see if the window is top if not then display button
    $(window).scroll(function(){
        if ($(this).scrollTop() > 1600) {
            $('.scrollToTop').fadeIn();
        } else {
            $('.scrollToTop').fadeOut();
        }
    });

    //Click event to scroll to top
    $('.scrollToTop').click(function(){
        $('html, body').animate({scrollTop : 0},800);
        return false;
    });

    var waypoint = new Waypoint({
        element: document.getElementById('container_introduction'),
        handler: function(direction) {
            $('#container_introduction .container_text').animate({opacity: "1"}, 1000);
        }
    });
    var waypoint2 = new Waypoint({
        element: document.getElementById('container_hasil'),
        handler: function(direction) {
            $('#container_hasil .container_text').animate({opacity: "1"}, 1000);
        }
    });
    var waypoint3 = new Waypoint({
        element: document.getElementById('container_hitung'),
        handler: function(direction) {
            $('#container_hitung .container_text').animate({opacity: "1"}, 1000);
        }
    });
    var waypoint4 = new Waypoint({
        element: document.getElementById('container_tambah'),
        handler: function(direction) {
            $('#container_tambah .container_text').animate({opacity: "1"}, 1000);
        }
    });
  
    
});