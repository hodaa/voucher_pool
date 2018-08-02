// A $( document ).ready() block.
$( document ).ready(function() {
    console.log( "ready!" );
});
$(function () {
    $("#datepicker").datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: new Date()
    });
});