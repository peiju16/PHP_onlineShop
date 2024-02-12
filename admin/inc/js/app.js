$(document).ready(function(){

    $("select").change(function() {
        $(this).parent().trigger("submit");
    });

});