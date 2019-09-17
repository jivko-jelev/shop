
@extends('admin.partials.master')

@section('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ URL::to('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
            <small>Контролен Панел</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Users</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ $user->fullName }}</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form class="form-horizontal" autocomplete="off" method="post" action="{{ route('users.update', $user) }}">
                        @method('put')
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="name" class="col-sm-4 control-label">Потребителско Име</label>

                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="name" placeholder="Потребителско Име" value="{{ old('name', $user->name) }}">
                                    @error('name')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-sm-4 control-label">Имейл</label>

                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="email" placeholder="Имейл" value="{{ old('email', $user->email) }}">
                                    @error('email')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-4 control-label">Парола</label>

                                <div class="col-sm-8">
                                    <input type="password" class="form-control" name="password" placeholder="Парола">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password-confirmation" class="col-sm-4 control-label">Повтори Паролата</label>

                                <div class="col-sm-8">
                                    <input type="password" class="form-control" name="password-confirmation" placeholder="Повтори Паролата">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="first_name" class="col-sm-4 control-label">Име</label>

                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="first_name" placeholder="Име" value="{{ old('email', $user->first_name) }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="last_name" class="col-sm-4 control-label">Фамилия</label>

                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="last_name" placeholder="Фамилия" value="{{ old('email', $user->last_name) }}">
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="{{ URL::previous() }}" class="btn btn-default">Назад</a>
                            <button type="submit" class="btn btn-primary pull-right">Промени</button>
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>
            </div>
            <!-- /.col -->
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
