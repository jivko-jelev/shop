@extends('admin.partials.master')

@section('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ URL::to('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('content')
    <div class="row" id="category-data">
        @include('admin.categories.edit-content')
    </div>
@endsection

@push('js')
    <script>
        $('.delete-property').click(function () {
            let that = $(this);
            Lobibox.confirm({
                msg: `Наистина ли искате да изтриете атрибута: <strong>${$(this).data('title')}</strong>?`,
                callback: function ($this, type) {
                    if (type === 'yes') {
                        $.ajax({
                            url: `${that.data('route')}`,
                            method: 'delete',
                            success: function (data) {
                                that.closest('.property').remove();
                                Lobibox.notify('success', {
                                    msg: `Атрибутът <strong>${that.data('title')}</strong> беше успешно изтрит`
                                });
                                table.ajax.reload()
                            }
                        });
                    }
                }
            });
        });

        $(document).on('click', '.delete-subproperty', function () {
            let that = $(this);
            if (that.data('saved') == 1) {
                Lobibox.confirm({
                    msg: `Наистина ли искате да изтриете податрибута: <strong>${that.data('title')}</strong>?`,
                    callback: function ($this, type) {
                        if (type === 'yes') {
                            $.ajax({
                                url: `${that.data('route')}`,
                                method: 'delete',
                                success: function (data) {
                                    that.closest('.form-group').remove();
                                    Lobibox.notify('success', {
                                        msg: `Податрибутът <strong>${that.data('title')}</strong> беше успешно изтрит`
                                    });
                                    table.ajax.reload()
                                },
                                error: function (data) {
                                    showError(data);
                                }
                            });
                        }
                    }
                });
            } else {
                that.closest('.form-group').remove();
            }
        });

        function grabSubmitButton() {
            $('#submit').click(function (e) {
                e.preventDefault();
                $.ajax({
                    url: '{{ route('categories.update', $category->id) }}',
                    method: 'put',
                    data: $('#form-category').serialize(),
                    success: function (data) {
                        showSuccessMessage(data.message);
                        $('#category-data').html(data.content);
                        grabSubmitButton();
                    },
                    error: function (data) {
                        showErrors(data);
                        console.log(data);
                    }
                });
            });
        }

        grabSubmitButton();

        let newSubProperty = 0;
        $(document).on('click', '.add-subproperty', function () {
            newSubProperty++;
            $(this).closest('.property').append('<div class="form-group">\n' +
                `                                        <label for="subproperty[${newSubProperty}]" class="col-sm-4 control-label">Нов податрибут\n` +
                '                                            </label>\n' +
                '                                        <div class="col-sm-8">\n' +
                '                                            <div class="input-group">\n' +
                `                                                <input type="text" class="form-control" name="new_subproperty[${$(this).closest('.property').data('id')}][${newSubProperty}]"\n` +
                `                                                       id="subproperty[${newSubProperty}]" placeholder="Атрибут"\n` +
                '                                                       value="">\n' +
                '                                                <span class="input-group-btn">\n' +
                '                                                <button type="button" class="btn btn-primary add-subproperty"\n' +
                '                                                        data-title=""\n' +
                '                                                        title="Добави податрибут">\n' +
                '                                                    <i class="fa fa-plus" aria-hidden="true"></i>\n' +
                '                                                </button>\n' +
                '                                                <button type="button" class="btn btn-danger delete-subproperty"\n' +
                '                                                        data-title="" data-saved="0">\n' +
                '                                                    <i class="fa fa-trash" aria-hidden="true"></i>\n' +
                '                                                </button>\n' +
                '                                            </span>\n' +
                '                                            </div>\n' +
                '                                            <span class="error" id="alias-error-modal"></span>\n' +
                '                                        </div>\n' +
                '                                    </div>');
        });
    </script>
@endpush
