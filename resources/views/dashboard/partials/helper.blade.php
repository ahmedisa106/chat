<script>

    $('.modal').on('hidden.bs.modal', function () {
        $('.modal form').trigger('reset');
        $('.modal form .img_preview').attr('src', '{{asset('defaults/default.jpg')}}');
        $('.is-invalid').removeClass('is-invalid');
        $('.errors').remove();
    })
    // img preview
    $('input[name="photo"]').on('change', function (e) {
        var photo = e.target.files[0];
        var url = URL.createObjectURL(photo);
        $(this).parents('.photo').find('.img_preview').attr('src', url)
    });


</script>

<script>
    function getSortedAdmins() {
        $.ajax({
            url: '{{route('dashboard.admins.getAdmins')}}',
            type: "get",
            success: function (response) {
                $('.people').html(response)
            }
        })
    }
</script>
