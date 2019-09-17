@extends('admin.partials.master')

@section('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ URL::to('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ __('Потребители') }}
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Users</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">{{ __('Потребители') }}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="users" class="table table-bordered table-hover">
                            <thead>
                            <tr role="row" class="heading">
                                <th>Username</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Sex</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Username</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Sex</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <!-- DataTables -->
    <script src="{{ URL::to('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::to('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script>
        $(function () {
            $('#users').DataTable({
                'paging': true,
                'lengthChange': true,
                'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': false,
                'processing': true,
                'serverSide': true,
                ajax: '{{ route('users.ajax') }}',
                columns: [
                    {data: 'name'},
                    {data: 'first_name'},
                    {data: 'last_name'},
                    {data: 'sex'},
                    {data: 'email'},
                    {data: 'actions'},
                ]
            });
        });
    </script>
@endpush
