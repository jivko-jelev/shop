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
                        <h3 class="box-title">{{ __('Основни данни за потребителя') }}</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form class="form-horizontal" id="form-edit-user" autocomplete="off" method="post"
                          action="{{ route('users.update', $user) }}">
                        @method('put')
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="name" class="col-sm-4 control-label">Потребителско Име</label>

                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="name" id="name"
                                           placeholder="Потребителско Име"
                                           value="{{ old('name', $user->name) }}" autocomplete="off">
                                    <span class="error" id="name-error"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-sm-4 control-label">Имейл</label>

                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="email" placeholder="Имейл"
                                           value="{{ old('email', $user->email) }}">
                                    <span class="error" id="email-error"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-4 control-label">Парола</label>

                                <div class="col-sm-8">
                                    <input type="password" class="form-control" name="password" placeholder="Парола">
                                    <span class="error" id="password-error"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation" class="col-sm-4 control-label">Повтори
                                    Паролата</label>

                                <div class="col-sm-8">
                                    <input type="password" class="form-control" name="password_confirmation"
                                           placeholder="Повтори Паролата">
                                    <span class="error" id="password_confirmation-error"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="first_name" class="col-sm-4 control-label">Име</label>

                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="first_name" placeholder="Име"
                                           value="{{ old('first_name', $user->first_name) }}">
                                    <span class="error" id="first_name-error"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="last_name" class="col-sm-4 control-label">Фамилия</label>

                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="last_name" placeholder="Фамилия"
                                           value="{{ old('last_name', $user->last_name) }}">
                                    <span class="error" id="last_name-error"></span>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="{{ URL::previous() }}" class="btn btn-default">Назад</a>
                            <button type="submit" id="submit" class="btn btn-primary pull-right">Промени</button>
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
        $('#submit').click(function (e) {
            e.preventDefault();
            var form = $("#form-edit-user");
            $.ajax({
                url: "{{ route('users.update', $user) }}",
                context: document.body,
                data: form.serialize(),
                method: 'post',
                success: function (data) {
                    $('.error').html('');
                    Lobibox.notify('success', {
                        showClass: 'rollIn',
                        hideClass: 'rollOut',
                        msg: JSON.parse(data).message
                    });
                },
                error: function (data) {
                    for (let i = 0; i < $('.error').length; i++) {
                        let key = Object.keys(data.responseJSON.errors)[i];
                        $('#' + key + '-error').html(data.responseJSON.errors[key]);
                    }
                    Lobibox.notify('error', {
                        showClass: 'rollIn',
                        hideClass: 'rollOut',
                        msg: 'Възникна някаква грешка при опита за промяна на данните на потребителя'
                    });
                }
            })
        })
    </script>
@endpush
