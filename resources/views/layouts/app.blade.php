<html>
<head>
    <title>Voucher Pool- @yield('title')</title>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="{{url('assets/css/index.css')}}" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script href="{{url('assets/js/index.js')}}" ></script>
    <script>
        $(function () {
            $("#datepicker").datepicker({
                dateFormat: 'dd-mm-yy',
                minDate: new Date()
            });

            $("#search").keyup(function(e){
                if(e.keyCode == 13) {
                    search = $("#search").val();
                    window.location = "http://voucher.test/?q="+search;
                }
            })
        });
    </script>


</head>
<body>

@yield('content')
</body>
</html>