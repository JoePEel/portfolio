
// Make hero image take up the full screen
var $winHeight = $(window).height();
$(".heroHome").css("height", $winHeight);

// Set Intro padding
var introPadding = $winHeight / 2 - 100;
$("#mainHeading").css("paddingTop", introPadding)




//Scroll to section from either nav
$(".nav-item, .listNav li").click(function(e) {
    e.preventDefault();
    var target = e.target.innerHTML;
    var lower = target.toLowerCase();
    
    //Set offset to take away so section title in view
    var extraOffset = 0;
    if(lower != "home"){
        extraOffset = 35;
    }
    
    //animate to position
    $('html, body').animate({
        scrollTop: ($("#" + lower).offset().top - extraOffset)
    }, 500);
    
});




// Load Side Nav and repsonsive top menu bar
$(".nav").hide();

$(document).ready(function() {
    $(window).on("scroll resize", function(){
        
        // Get Height of backgroud image
        var bottomOfHero = $(".heroHome").height();
        var width = $(window).width();
        // If herp image moves out of sight, load side nav
        if($(window).scrollTop() > (bottomOfHero - 150) && width > 990){
            $(".nav").slideDown();
        } else {
            $(".nav").fadeOut();
        }
          
        // If screen width narrow, make top nav sticky    
        if(width < 990 && ($(window).scrollTop() > 50)){
            $(".topNav").addClass("sticky");
        } else {
            $(".topNav").removeClass("sticky");
        }
     });
    
});




$("#mobileIcon").hide();

//Hide top menu and bring icon into view
function mobileMenu(){
    var width = $(window).width();
    if(width < 990){
        $("#mobileIcon").show();
        $(".listNav").hide().addClass("mobileView");
    } else {
        $("#mobileIcon").hide();
        $(".listNav").show().removeClass("mobileView");   
    }
} 

//Listen if device is resized and run first time
$(window).on("resize", mobileMenu);
$(window).trigger("resize");




//Show mobile menu li items
$("#mobileIcon").on("click", function(){
    if ( $(".listNav").is(":hidden")){
        $(".listNav").slideDown();
    } else {
        $(".listNav").slideUp();
    }
});









