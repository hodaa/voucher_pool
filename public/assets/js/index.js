// $('#myModal').on('shown.bs.modal', function () {
//     $('#myInput').trigger('focus')
// })
//
// $(document).ready(function(){
//     // $('#datetimepicker1').datetimepicker();
//
//     $("#mytable #checkall").click(function () {
//         if ($("#mytable #checkall").is(':checked')) {
//             $("#mytable input[type=checkbox]").each(function () {
//                 $(this).prop("checked", true);
//             });
//
//         } else {
//             $("#mytable input[type=checkbox]").each(function () {
//                 $(this).prop("checked", false);
//             });
//         }
//     });
//
//     $("[data-toggle=tooltip]").tooltip();
//
//
//     $( "#datepicker" ).datepicker();
// });

$(function() {
    $('#datetimepicker1').datetimepicker({
     dateFormat: 'dd-mm-YYYY'
    });
});
