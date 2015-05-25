/**
 * Created by Sanam on 5/25/15.
 */

$(document).ready(function(){
    $(".nav a").on("click", function(){
        $(".nav").find(".active-nav").removeClass("active-nav");
        $(this).parent().addClass("active-nav");
    });
});