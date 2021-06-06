$(document).ready(function() {

    $(".fav").on("click", function () {

        //Ajax call
        $.ajax({
            type: "POST",
            url: "index.php",
            success: function(html){
                window.location.reload();}
        })
    });

    $(".fav-delete").on("click", function () {

        //Ajax call
        $.ajax({
            type: "POST",
            url: "index.php",
            success: function(html){
                window.location.reload();}
        })
    });
})