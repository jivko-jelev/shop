@extends('admin.partials.master')

@section('styles')
@endsection

@section('content')
    <div class="row" id="category-data">
        @include('admin.categories.edit-content')
    </div>
@endsection

@push('js')
    <script>
        $(document).on('click', '.delete-property', function () {
            let that = $(this);
            if (that.data('saved') == 1) {
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
                                }
                            });
                        }
                    }
                });
            } else {
                that.closest('.property').remove();
            }
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
                                    let parent = that.closest('.property');
                                    that.closest('.form-group').remove();
                                    let count = 0;
                                    parent.find('label').each(function () {
                                        if (count++ > 0) {
                                            $(this).html(`Податрибут #${count - 1}`);
                                        }

                                    });
                                    Lobibox.notify('success', {
                                        msg: `Податрибутът <strong>${that.data('title')}</strong> беше успешно изтрит`
                                    });
                                },
                                error: function (data) {
                                    showError(data);
                                }
                            });
                        }
                    }
                });
            } else {
                if (that.closest('.property').find('input').length > 2) {
                    that.closest('.form-group').remove();
                }
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
                '                                        <div class="col-sm-8 error-div">\n' +
                '                                            <div class="input-group">\n' +
                `                                                <input type="text" class="form-control" name="new_subproperty[${$(this).closest('.property').data('id')}][${newSubProperty}]"\n` +
                `                                                       id="subproperty[${newSubProperty}]" placeholder="Податрибут"\n` +
                '                                                       value="">\n' +
                '                                                <span class="input-group-btn">\n' +
                '                                                <button type="button" class="btn btn-primary add-subproperty"\n' +
                '                                                        title="Добави податрибут">\n' +
                '                                                    <i class="fa fa-plus" aria-hidden="true"></i>\n' +
                '                                                </button>\n' +
                '                                                <button type="button" class="btn btn-danger delete-subproperty" title="Изтрий">\n' +
                '                                                    <i class="fa fa-minus" aria-hidden="true"></i>\n' +
                '                                                </button>\n' +
                '                                            </span>\n' +
                '                                            </div>\n' +
                '                                            <span class="error" id="alias-error-modal"></span>\n' +
                '                                        </div>\n' +
                '                                    </div>');
        });

        $(document).on('click', '.add-property-subproperty', function () {
            newSubProperty++;
            $(this).closest('.property').append('<div class="form-group">\n' +
                `                                        <label for="subproperty[${newSubProperty}]" class="col-sm-4 control-label">Нов податрибут\n` +
                '                                            </label>\n' +
                '                                        <div class="col-sm-8 error-div">\n' +
                '                                            <div class="input-group">\n' +
                `                                                <input type="text" class="form-control" name="new_property_subproperty[${newProperty}][${newSubProperty}]"\n` +
                `                                                       id="subproperty[${newSubProperty}]" placeholder="Податрибут"\n` +
                '                                                       value="">\n' +
                '                                                <span class="input-group-btn">\n' +
                '                                                <button type="button" class="btn btn-primary add-property-subproperty"\n' +
                '                                                        title="Добави податрибут">\n' +
                '                                                    <i class="fa fa-plus" aria-hidden="true"></i>\n' +
                '                                                </button>\n' +
                '                                                <button type="button" class="btn btn-danger delete-subproperty" title="Изтрий">\n' +
                '                                                    <i class="fa fa-minus" aria-hidden="true"></i>\n' +
                '                                                </button>\n' +
                '                                            </span>\n' +
                '                                            </div>\n' +
                '                                            <span class="error" id="alias-error-modal"></span>\n' +
                '                                        </div>\n' +
                '                                    </div>');
        });

        let newProperty = 0;

        $(document).on('click', '.add-property', function () {
            newProperty++;
            newSubProperty++
            $('#form-category').find('.modal-footer').last().before(
                '                    <div class="property">\n' +
                '                        <hr>\n' +
                '                        <div class="form-group">\n' +
                `                            <label for="new_property[${newProperty}]" class="col-sm-4 control-label">Нов атрибут</label>\n` +
                '                            <div class="col-sm-8 error-div">\n' +
                '                                <div class="input-group">\n' +
                `                                    <input type="text" class="form-control" name="new_property[${newProperty}]"\n` +
                `                                           id="new_property[${newProperty}]" placeholder="Атрибут">\n` +
                '                                    <span class="input-group-btn">\n' +
                '                                                <button type="button" class="btn btn-primary add-property">Добави атрибут</button>\n' +
                '                                                <button type="button" class="btn btn-danger delete-property">\n' +
                '                                                   Изтрий</button>\n' +
                '                                            </span>\n' +
                '                                </div>\n' +
                '                            </div>\n' +
                '                        </div>\n' +
                '                                        <div class="form-group">\n' +
                `                                               <label for="subproperty[${newProperty}][${newSubProperty}]" class="col-sm-4 control-label">Нов податрибут\n` +
                '                                            </label>\n' +
                '                                        <div class="col-sm-8 error-div">\n' +
                '                                            <div class="input-group">\n' +
                `                                                <input type="text" class="form-control" name="new_property_subproperty[${newProperty}][${newProperty}]"\n` +
                `                                                       id="subproperty[${newProperty}][${newSubProperty}]" placeholder="Податрибут"\n` +
                '                                                       value="">\n' +
                '                                                <span class="input-group-btn">\n' +
                '                                                <button type="button" class="btn btn-primary add-property-subproperty"\n' +
                '                                                        title="Добави податрибут">\n' +
                '                                                    <i class="fa fa-plus" aria-hidden="true"></i>\n' +
                '                                                </button>\n' +
                '                                                <button type="button" class="btn btn-danger delete-subproperty" title="Изтрий">\n' +
                '                                                    <i class="fa fa-minus" aria-hidden="true"></i>\n' +
                '                                                </button>\n' +
                '                                            </span>\n' +
                '                                            </div>\n' +
                '                                            <span class="error" id="alias-error-modal"></span>\n' +
                '                                        </div></div>\n');
        });
    </script>
@endpush
