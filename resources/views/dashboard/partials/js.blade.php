<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="{{asset('assets/dashboard')}}/assets/js/libs/jquery-3.1.1.min.js"></script>
<script src="{{asset('assets/dashboard')}}/bootstrap/js/popper.min.js"></script>
<script src="{{asset('assets/dashboard')}}/bootstrap/js/bootstrap.min.js"></script>
<script src="{{asset('assets/dashboard')}}/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="{{asset('assets/dashboard')}}/plugins/fontawesome/fontawesome.min.js"></script>
<script src="{{asset('assets/dashboard')}}/assets/js/app.js"></script>
<script>
    $(document).ready(function () {
        App.init();
    });
</script>
<script src="{{asset('assets/dashboard')}}/assets/js/custom.js"></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->

<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
{{--<script src="{{asset('assets/dashboard')}}/plugins/apex/apexcharts.min.js"></script>--}}
<script src="{{asset('assets/dashboard')}}/assets/js/dashboard/dash_1.js"></script>
<script src="{{asset('assets/dashboard/plugins/moment/moment.min.js')}}"></script>
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
@include('dashboard.partials.swal')
@include('dashboard.partials.helper')
@stack('js')
