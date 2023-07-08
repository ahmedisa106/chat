<!-- toastr -->
<link href="{{asset('assets/dashboard')}}/plugins/notification/snackbar/snackbar.min.css" rel="stylesheet" type="text/css"/>

<!-- toastr -->
<script src="{{asset('assets/dashboard')}}/plugins/notification/snackbar/snackbar.min.js"></script>
<!--  BEGIN CUSTOM SCRIPTS FILE  -->
<script src="{{asset('assets/dashboard')}}/assets/js/components/notification/custom-snackbar.js"></script>
<!--  END CUSTOM SCRIPTS FILE  -->

<script>
    function alertError(error) {
        Snackbar.show({
            text: error,
            pos: 'bottom-left',
            actionTextColor: '#fff',
            backgroundColor: '#e2a03f'
        });
    }

    function alertSuccess(message) {
        Snackbar.show({
            text: message,
            pos: 'bottom-left',
            actionTextColor: '#fff',
            backgroundColor: '#1abc9c'
        });
    }
</script>
@if(session('error'))
    <script>
        alertError('{{session('error')}}');
    </script>
@elseif(session('success'))
    <script>
        alertSuccess('{{session('success')}}');
    </script>
@endif



