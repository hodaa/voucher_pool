// A $( document ).ready() block.
$( document ).ready(function() {
    $("#datepicker").datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: new Date()
    });

    $("#search").keyup(function (e) {
        if (e.keyCode == 13) {
            url = $("#url").val();
            search = $("#search").val();
            window.location = url + "/?q=" + search;
        }
    })
});
