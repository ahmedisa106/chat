<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from designreset.com/cork/ltr/demo4/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 23 Jun 2022 14:44:36 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title> Dashboard | @yield('title')</title>


    @include('dashboard.partials.css')

</head>
<body>
@include('dashboard.partials.header')

<!--  BEGIN MAIN CONTAINER  -->
<div class="main-container" id="container">

    <div class="overlay"></div>
    <div class="search-overlay"></div>

    @include('dashboard.partials.aside')

    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">

            <div class="row layout-top-spacing">


                @yield('content')


            </div>
            @include('dashboard.partials.footer')
        </div>
        <!--  END CONTENT AREA  -->

    </div>
</div>
<!-- END MAIN CONTAINER -->

@include('dashboard.partials.js')
<script src="https://cdn.socket.io/4.6.0/socket.io.min.js" integrity="sha384-c79GN5VsunZvi+Q/WObgk2in0CbZsHnjEqvFxC5DxHn9lTfNce2WW6h2pH6u/kF+" crossorigin="anonymous"></script>


<script>
    const socket = io('http://localhost:8001', {transports: ['websocket', 'polling', 'flashsocket']});


    socket.on('connect', function () {
        socket.emit('admin_connected', {
            'id': '{{auth('admin')->user()->id}}',
            'name': '{{auth('admin')->user()->name}}',
        });
    })
    // socket.on('admin_is_online', function (data) {
    //     alertSuccess(data.name + ' Is Online Now');
    // })

    socket.on('update_admin_status', function (admins) {
        $('.admin-status').removeClass('text-success');
        $.each(admins, function (id, value) {
            if (value != null && value !== 0) {
                $('.admin-status-' + id).addClass('text-success');
            }

        })
    })

</script>
</body>

</html>
