<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from designreset.com/cork/ltr/demo4/auth_login_boxed.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 23 Jun 2022 14:46:25 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Dashboard | login</title>
    <link rel="icon" type="image/x-icon" href="{{asset('assets/dashboard')}}/assets/img/favicon.ico"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{asset('assets/dashboard')}}/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/dashboard')}}/assets/css/plugins.css" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/dashboard')}}/assets/css/authentication/form-2.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/dashboard')}}/assets/css/forms/theme-checkbox-radio.css">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/dashboard')}}/assets/css/forms/switches.css">


</head>
<body class="form">


<div class="form-container outer">
    <div class="form-form">
        <div class="form-form-wrap">
            <div class="form-container">
                <div class="form-content">

                    <h1 class="">Sign In</h1>

                    <form class="text-left" method="post" action="{{route('dashboard.doLogin')}}">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="form">

                            <div id="username-field" class="field-wrapper input">
                                <label for="email">Email</label>
                                <input id="email" name="email" value="{{old('email')}}" type="text" class="form-control" placeholder="Email">
                                @error('email')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div id="password-field" class="field-wrapper input mb-2">
                                <div class="d-flex justify-content-between">
                                    <label for="password">PASSWORD</label>
                                    <a href="auth_pass_recovery_boxed.html" class="forgot-pass-link">Forgot Password?</a>
                                </div>
                                <input id="password" name="password" type="password" class="form-control" placeholder="Password">
                                @error('password')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="d-sm-flex justify-content-between">
                                <div class="field-wrapper">
                                    <button type="submit" class="btn btn-primary" value="">Log In</button>
                                </div>
                            </div>


                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>


<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="{{asset('assets/dashboard')}}/assets/js/libs/jquery-3.1.1.min.js"></script>
<script src="{{asset('assets/dashboard')}}/bootstrap/js/popper.min.js"></script>
<script src="{{asset('assets/dashboard')}}/bootstrap/js/bootstrap.min.js"></script>

<!-- END GLOBAL MANDATORY SCRIPTS -->
<script src="{{asset('assets/dashboard')}}/assets/js/authentication/form-2.js"></script>
@include('dashboard.partials.swal')

</body>




<script>
    // const socket = io('http://localhost:8001', {transports: ['websocket', 'polling', 'flashsocket']});


</script>
<script>
    $('form').on('submit', function (e) {
        e.preventDefault();
        let url = $(this).attr('action'),
            data = new FormData(this);

        $.ajax({
            type: "post",
            url: url,
            data: data,
            processData: false,
            cache: false,
            contentType: false,
            success: function (response) {
                // socket.emit('admin_is_online', {
                //     'name': response.name,
                //     'id': response.id,
                // });
                window.location.href = '{{route('dashboard.index')}}'
            },
            error: function (xhr) {
                alertError(xhr.responseJSON.message);
            }

        })
    })
</script>
<!-- Mirrored from designreset.com/cork/ltr/demo4/auth_login_boxed.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 23 Jun 2022 14:46:25 GMT -->
</html>
