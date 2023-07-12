@extends('dashboard.layouts.master')

@push('css')

    <link rel="stylesheet" type="text/css" href="{{asset('assets/dashboard')}}/plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/dashboard')}}/assets/css/forms/theme-checkbox-radio.css">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/dashboard')}}/plugins/table/datatable/dt-global_style.css">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/dashboard')}}/plugins/table/datatable/custom_dt_custom.css">
@endpush
@section('content')

    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">

                </div>

            </div>

            <div class="widget-content widget-content-area">
                <div class="row layout-spacing">
                    <div class="col-lg-12">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-content widget-content-area">
                                <table id="datatable" class="table style-1 dt-table-hover non-hover">
                                    <thead>
                                    <tr>
                                        <th class="checkbox-column dt-no-sorting"> Record no.</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th class="text-center dt-no-sorting">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Admin</h5>

                </div>
                <div class="modal-body">

                    <form action="{{route('dashboard.admins.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">name :</label>
                                    <input type="text" class="form-control" name="name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Email :</label>
                                    <input type="email" class="form-control" name="email">
                                </div>
                            </div>

                        </div>

                        <div class="row photo">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="d-block" for="">Photo :</label>
                                    <input type="file" accept="image/*" class="" name="photo">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <img class="img_preview" style="width: 100px; height: 100px" src="{{asset('defaults/default.jpg')}}" alt="">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Password :</label>
                                    <input type="password" class="form-control" name="password">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Password Confirmation :</label>
                                    <input type="password" class="form-control" name="password_confirmation">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>
@endsection
@push('js')

    <script src="{{asset('assets/dashboard')}}/plugins/table/datatable/datatables.js"></script>


    <!-- NOTE TO Use Copy CSV Excel PDF Print Options You Must Include These Files  -->
    <script src="{{asset('assets/dashboard')}}/plugins/table/datatable/button-ext/dataTables.buttons.min.js"></script>


    <script>
        $(function () {
            var table = $('#datatable').DataTable({
                "dom": "<'dt--top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'B><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f>>>" +
                    "<'table-responsive'tr>" +
                    "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",

                "lengthMenu": [5, 10, 20, 50],
                "pageLength": 10,
                "serverSide": true,
                "processing": true,
                "ajax": {
                    url: "{{route('dashboard.admins.data')}}",
                },
                buttons: {
                    buttons: [
                        {
                            text: '<button type="button" class="btn btn-primary mb-2 mr-2" data-toggle="modal" data-target="#modal"> Add New Admin </button>', className: 'btn   btn-primary',
                            action: function () {
                                $('#modal').modal('show')
                            }
                        },

                    ]
                },


                columns: [
                    {
                        name: "DT_RowIndex", data: 'DT_RowIndex', searchable: false, orderable: false
                    },
                    {
                        name: "name", data: 'name'
                    },
                    {
                        name: "email", data: 'email'
                    },
                    {
                        name: "actions", data: 'actions', searchable: false, orderable: false
                    },
                ]
            });
        })
    </script>

    {{--add new admin--}}

    <script>
        $('.modal form').on('submit', function (e) {
            e.preventDefault();
            var url = $(this).attr('action'),
                data = new FormData(this);
            data.append('_token', '{{csrf_token()}}');
            $.ajax({
                url: url,
                type: "post",
                data: data,
                cache: false,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('.errors').remove();
                    $('.is-invalid').removeClass('is-invalid');
                },
                success: function (response) {
                    $('#datatable').DataTable().draw();
                    $('.modal').modal('hide');
                },
                error: function (xhr) {
                    var errors = xhr.responseJSON.errors;
                    alertError(xhr.responseJSON.message)
                    $.each(errors, function (key, value) {
                        var input = $('input[name="' + key + '"]');
                        input.addClass('is-invalid');
                        input.parent().append('<span class="errors text-danger">' + value + '</span>')
                    })
                }
            })
        })
    </script>

@endpush

