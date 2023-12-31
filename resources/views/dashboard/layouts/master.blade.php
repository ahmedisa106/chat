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

            {{--            <div class="row layout-top-spacing">--}}


            @yield('content')


            {{--            </div>--}}
            @include('dashboard.partials.footer')
        </div>
        <!--  END CONTENT AREA  -->

    </div>
</div>
<!-- END MAIN CONTAINER -->

@include('dashboard.partials.js')
<script src="https://cdn.socket.io/4.6.0/socket.io.min.js" integrity="sha384-c79GN5VsunZvi+Q/WObgk2in0CbZsHnjEqvFxC5DxHn9lTfNce2WW6h2pH6u/kF+" crossorigin="anonymous"></script>


<script>
    var partner_is_in_my_chat = false;
    var partner_id = '';
    const socket = io('http://localhost:5000');
    socket.on('connect', function () {
        socket.emit('admin_connected', {
            'id': '{{auth('admin')->user()->id}}',
            'name': '{{auth('admin')->user()->name}}',
        });


    });

    socket.on('update_admin_status', function (admins) {
        $('.admin-status').removeClass('text-success');
        $.each(admins, function (id, value) {
            if (value != null && value !== 0) {

                $('.admin-status-' + id).addClass('text-success');
                $(`.active-chat-${id} .me span i:not(text-success , fa-check-double)`).addClass('fa-check-double')
            }
        });
    });
    socket.on('send_message', function (data) {
        $('.admin_status_typing').empty();
        var in_chat = 0;

        var sender = +data.sender_id;
        var partner = +partner_id
        var receiver = +data.receiver_id
        if (sender !== partner) {
            alertSuccess('New Message From ' + data.sender_name);
        } else {

            var message = `<div class="bubble you">${data.message}  </br>   <span class=""  style="font-size: 10px;color: black">${moment().format(' hh:mm A')}</span> </div> `
            $('.active-chat-' + data.sender_id).append(message);
            const getScrollContainer = document.querySelector('.chat-conversation-box');
            getScrollContainer.scrollTo(0, getScrollContainer.scrollHeight);

            in_chat = 1;
            $.ajax({
                type: "post",
                url: '{{route('dashboard.chat.makeMessagesRead')}}',
                data: {
                    "_token": "{{csrf_token()}}",
                    sender,
                    receiver
                }
            })
        }

        getSortedAdmins(in_chat, receiver);


    });

    socket.on('admin_typing', function (data) {
        $('#' + data).text('typing...');
        $('#admin_' + data).text('typing...');

    });

    socket.on('admin_stop_type', function (data) {
        $('.admin_status_typing').empty();
        $('#' + data).text('');
        $('#admin_' + data).text('');

    });

    socket.on('i_open_our_chat', function (data) {
        /* $('.admin_status_typing_inside_chat').text('online')*/
        $(`.active-chat-${data.sender} .me span i`).addClass('text-success fa-check-double')
    })
    socket.on('who_you_chat', function (data) {

        let sender = data.sender_id;
        let partner = data.partner_id;
        socket.emit('i_chat_with', {
            partner_id,
            sender,
            partner


        })
    })

    socket.on('i_chat_with', function (data) {
        console.log(data)
        if (data.partner_id !== '' && data.partner_id == '{{auth('admin')->id()}}') {
            partner_is_in_my_chat = true;
            $('.active-chat .me span i').addClass('text-success fa-check-double')
        } else if (data.partner_id !== '{{auth('admin')->id()}}') {
            $('.active-chat .me span i:not(text-success , fa-check-double)').addClass('fa-check-double')
            partner_is_in_my_chat = false;
        }
    })

    $(document).ajaxComplete(function () {
        socket.emit('admin_connected', {
            'id': '{{auth('admin')->user()->id}}',
            'name': '{{auth('admin')->user()->name}}',
        });
    })

</script>


</body>

</html>
