$(document).ready(function() {

    $(".search").on("click", function () {

        //Ajax call
        $.ajax({
            type: "POST",
            url: "search.php",

        })
    });

})