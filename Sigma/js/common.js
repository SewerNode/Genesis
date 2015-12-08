jQuery(document).ready(function ($) {
    $("ul.menu-mobile").before('<div id="primary-menu-toggle" class="menu-toggle primary"><a class="toggle-switch show" href="#"><span>Menu</span></a></div>');
    $("#primary-menu-toggle .show").click(function () {
        if ($(".menu-mobile").is(":hidden")) {
            $(".menu-mobile").slideDown(500);
        } else {
            $(".menu-mobile").hide(500);
        }
    });
    
    jQuery(".scroll, .gototop a").click(function (e) {
        e.preventDefault();
        jQuery("html,body").animate({
            scrollTop: jQuery(this.hash).offset().top
        }, 500)
    })
})