<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        Laravel
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <!-- CSS Files -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="../assets/demo/demo.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css" rel="stylesheet" />
    <style>
        .loading-spinner {
            width: 60px;
            height: 60px;
            border: 2px solid rgb(109, 109, 109);
            border-radius: 50%;
            border-top-color: rgba(71, 70, 70, 0.067);
            display: inline-block;
            animation: loadingspinner .7s linear infinite;
        }

        @keyframes loadingspinner {
            0% {
                transform: rotate(0deg)
            }

            100% {
                transform: rotate(360deg)
            }
        }

        .bootstrap-tagsinput {
            background-color: #fff;
            border: 1px solid #DDDDDD;
            display: inline-block;
            padding: 6px 6px;
            color: #555;
            vertical-align: middle;
            border-radius: 4px;
            width: 100%;
            line-height: 22px;
            cursor: text;
        }

        .bootstrap-tagsinput input {
            border: none;
            box-shadow: none;
            outline: none;
            background-color: transparent;
            padding: 0 6px;
            margin: 0;
            width: auto;
            max-width: inherit;
        }

        .bootstrap-tagsinput.form-control input::-moz-placeholder {
            color: #777;
            opacity: 1;
        }

        .bootstrap-tagsinput.form-control input:-ms-input-placeholder {
            color: #777;
        }

        .bootstrap-tagsinput.form-control input::-webkit-input-placeholder {
            color: #777;
        }

        .bootstrap-tagsinput input:focus {
            border: none;
            box-shadow: none;
        }

        .bootstrap-tagsinput .badge {
            margin: 0px 4px;
            padding: 8px 8px;
        }

        .bootstrap-tagsinput .badge [data-role="remove"] {
            margin-left: 8px;
            cursor: pointer;
        }

        .bootstrap-tagsinput .badge [data-role="remove"]:after {
            content: "×";
            padding: 0px 4px;
            background-color: rgba(0, 0, 0, 0.1);
            border-radius: 50%;
            font-size: 13px
        }

        .bootstrap-tagsinput .badge [data-role="remove"]:hover:after {

            background-color: rgba(0, 0, 0, 0.62);
        }

        .bootstrap-tagsinput .badge [data-role="remove"]:hover:active {
            box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
        }

        .tt-menu {
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1000;
            display: none;
            float: left;
            min-width: 160px;
            padding: 5px 0;
            margin: 2px 0 0;
            list-style: none;
            font-size: 14px;
            background-color: #ffffff;
            border: 1px solid #cccccc;
            border: 1px solid rgba(0, 0, 0, 0.15);
            border-radius: 4px;
            -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
            background-clip: padding-box;
            cursor: pointer;
        }

        .tt-suggestion {
            display: block;
            padding: 3px 20px;
            clear: both;
            font-weight: normal;
            line-height: 1.428571429;
            color: #333333;
            white-space: nowrap;
        }

        .tt-suggestion:hover,
        .tt-suggestion:focus {
            color: #ffffff;
            text-decoration: none;
            outline: 0;
            background-color: #428bca;
        }
    </style>
    @yield('style')
</head>

<body style="background-color: #e4e4e4c4 !important;">
    <div class="wrapper">
        <div class="container">
            <div class="content mt-4">
                @include('layouts.header')
                @include('layouts.form-mail')
                @include('layouts.mail-history')
            </div>
        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="../assets/js/core/jquery.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/demo/demo.js"></script>
    <!-- Main Script Dashboard -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            var postData = {
                _token: "{{ csrf_token() }}"
            }
            $('#myTable').dataTable({
                "ordering": false,
                "serverSide": true,
                "processing": true,
                "pageLength": 10,
                "ajax": {
                    "url": "{{ url('fetch-mailhistory') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": postData
                },
                "columns": [
                    {"data": 'email'},
                    {"data": 'subject'},
                    {"data": 'description'},
                    {"data": 'status',"className": "text-center"},
                    {"data": 'date_time',"className": "text-right"}
                ]
            });
        });
    </script>
    <!-- Form Script Ajax -->
    <script>
        $(document).ready(function() {
            $("form").submit(function(e) {
                $('#confimreHidden').attr('data-toggle', 'modal');
                $('#confimreHidden').attr('data-target', '#exampleModal');
                $("#confimreHidden").click();
                e.preventDefault();
            });
            $('#ButtonConfirmeSending').click(function(e) {
                $('#defaultContent').fadeOut("slow");
                $('#loadingData').fadeIn("slow");
                // Set Data Values
                var postData = $('#multipleMailSend').serialize();
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ url('mailsending') }}",
                    data: postData,
                    success: function(response) {
                        if (response.status == false) {
                            $('#loadingData').fadeOut("slow");
                            $('#loadingError').show("slow");
                        } else {
                            $('#loadingData').hide("slow");
                            $('#loadingComplete').show("slow");
                        }
                    },
                    error: function(response) {
                        $('#loadingData').fadeOut("slow");
                        $('#loadingError').show("slow");
                        console.log(response);
                    }
                });
            });
        });
    </script>

</body>

</html>
