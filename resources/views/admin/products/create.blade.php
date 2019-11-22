@extends('admin.partials.master')

@section('styles')
@endsection

@section('content')
    <div class="row">
        <form action="" class="form-horizontal" id="create-product" autocomplete="off">
            <div class="col-xs-10">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">{{ $title }}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="title" class="col-sm-2 control-label">Име</label>

                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="title" id="title" placeholder="Име">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default">Запази</button>
                                        </span>
                                    </div>
                                    <span class="error" id="title-error"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="category" class="col-sm-2 control-label">Категория</label>

                                <div class="col-sm-3">
                                    <select class="form-control select2" id="category" name="category">
                                        <option value="">избери</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->title }}
                                                ({{ $category->alias }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="error" id="category-error"></span>
                                </div>


                                {{--                                <label for="title" class="col-sm-2 control-label">Пермалинк</label>--}}

                                {{--                                <div class="col-sm-4">--}}
                                {{--                                    <a href="">{{ route('products.index', 1) }}</a>--}}
                                {{--                                    <input type="text" class="form-control" name="title" id="title" placeholder="Име">--}}
                                {{--                                    <span class="error" id="title-error"></span>--}}
                                {{--                                </div>--}}
                                <label for="price" class="col-sm-1 control-label">Цена</label>

                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="number" step=".01" class="form-control" name="price" id="price" placeholder="Цена">
                                    </div>
                                    <span class="error" id="price-error"></span>
                                </div>

                                <label for="promo_price" class="col-sm-2 control-label">Промо цена</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="promo_price" id="promo_price" placeholder="Промо цена">
                                    </div>
                                    <span class="error" id="promo_price-error"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <textarea name="description" id="description"></textarea>
                                    <span class="error" id="description-error"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-3">
                                    <p>Процесори</p>
                                    <input type="checkbox" id="minimal-checkbox-1">
                                    <label for="minimal-checkbox-1">&nbsp Checkbox 1</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Снимка</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <button type="button" class="btn btn-default btn-block" id="select-picture-button" data-toggle="modal"
                                data-target="#select-picture-modal">
                            Избери снимка
                        </button>
                        <a href="#" id="remove-product-picture">Премахни снимка</a>
                        <p id="product-picture"></p>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Галерия</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <button type="button" class="btn btn-default btn-block" id="select-pictures-button" data-toggle="modal"
                                data-target="#select-pictures-modal">
                            Избери снимки
                        </button>
                        <a href="#" id="remove-product-pictures">Премахни снимките</a>
                        <p id="product-pictures" class="product-pictures">
                        </p>
                    </div>
                </div>
            </div>
            <p type="hidden" id="picture-id" name="picture-id"></p>
            <p type="hidden" id="pictures-id" name="pictures_id"></p>
        </form>
        <!-- Modal -->
        <div class="modal fade center" id="myModal" role="dialog">
        </div>

        <div class="modal fade" id="select-picture-modal" role="dialog">
            <div class="modal-dialog modal-xl">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Снимки</h4>
                    </div>
                    <div class="modal-body">
                        <select id="selectable">
                        </select>
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('pictures.store') }}" method="post" enctype="multipart/form-data" class="product-picture-form">
                            <input type="file" name="picture[]" multiple="multiple" class="btn btn-success pull-left" id="product-picture-pictures">
                            <input type="submit" value="Upload Image" name="submit" class="btn btn-success pull-left">
                        </form>
                        <span class="pull-left pictures-num"></span>
                        <a class="btn btn-default" data-dismiss="modal">Затвори</a>
                        <button type="button" name="save" class="btn btn-primary pull-right">Запази</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="select-pictures-modal" role="dialog">
            <div class="modal-dialog modal-xl">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Снимки</h4>
                    </div>
                    <div class="modal-body">
                        <select id="selectables" multiple="multiple">
                        </select>
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('pictures.store') }}" method="post" enctype="multipart/form-data" class="product-picture-form">
                            <input type="file" name="picture[]" multiple="multiple" class="btn btn-success pull-left" id="product-pictures-pictures">
                            <input type="submit" value="Upload Image" name="submit" class="btn btn-success pull-left">
                        </form>
                        <span class="pull-left pictures-num"></span>
                        <a class="btn btn-default" data-dismiss="modal">Затвори</a>
                        <button type="button" name="save" class="btn btn-primary pull-right">Запази</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="loading">
        <div class="lds-spinner">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
@endsection

@push('js')
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script type="text/javascript">
        var editor_config = {
            path_absolute: "{{ URL::to('/') }}/",
            selector: "#description",
            height: 300,
            fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern codesample"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic underline | fontselect | fontsizeselect | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | code",
            codesample_languages: [
                {text: 'PHP', value: 'php'},
                {text: 'HTML/XML', value: 'markup'},
                {text: 'JavaScript', value: 'javascript'},
                {text: 'CSS', value: 'css'},
                {text: 'MySQL', value: 'sql'},
            ],
            relative_urls: false,
            file_browser_callback: function (field_name, url, type, win) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

                var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
                if (type == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.open({
                    file: cmsURL,
                    title: 'Filemanager',
                    width: x * 0.8,
                    height: y * 0.8,
                    resizable: "yes",
                    close_previous: "no"
                });
            }
        };

        tinyMCE.init(editor_config);

        $('#create-product').submit(function (e) {
            e.preventDefault();
            $("textarea[name=description]").val(tinyMCE.activeEditor.getContent())
            let form = $(this);
            $.ajax({
                url: "{{ route('products.store') }}",
                data: form.serialize(),
                method: 'post',
                success: function (data) {
                    window.location.replace(data['url']);
                },
                error: function (data) {
                    showErrors(data);
                }
            });
        });

        function productPicture(majorButton, selectable, pictureModal, productPicture, pictureId, picture) {
            let reloadPictures = function (selectable, pictureModal, productPicture, pictureId) {
                let map = [];
                $(pictureId + ' input').each(function () {
                    map.push($(this).val());
                });
                $.ajax({
                    method: 'post',
                    data: {picture: map},
                    dataType: 'json',
                    url: '{{ route('thumbnails.index') }}',
                    success: function (data) {
                        $(selectable).html('');
                        $(pictureModal).on('hidden.bs.modal', function () {
                            $(selectable).html('');
                            $('.product-picture-form').off();
                        });
                        $(selectable).append('<option></option>');
                        $('.pictures-num').html(`Снимки: ${data.length}`);
                        for (let i = 0; i < data.length; i++) {
                            let isSelected = '';
                            $(productPicture).find('img').each(function () {
                                if ($(this).attr('src') == '{{ URL::to('') }}/' + data[i].filename) {
                                    isSelected = 'selected';
                                    return;
                                }
                            });
                            let label = data[i].filename.substring(data[i].filename.lastIndexOf('/'));
                            label     = label.substring(0, label.lastIndexOf('-'));
                            label     = label.substring(1, 18);
                            $(selectable).append('<option data-img-src="{{ URL::to('') }}/' + `${data[i].filename}" value="${data[i].picture_id}" data-img-label="${label}" ${isSelected}></option>`);
                        }

                        $(selectable).imagepicker({
                            show_label: true,
                        });
                    },
                });
            };
            let initModal      = function (majorButton, selectable, pictureModal, productPicture, pictureId, picture) {
                $(majorButton).click(function (e) {
                    reloadPictures(selectable, pictureModal, productPicture, pictureId);
                    $(`${pictureModal} [name="save"]`).click(function (e) {
                        $(pictureModal).modal('hide');
                        if ($(`${selectable} option:selected`).data('img-src')) {
                            $(productPicture).html('');
                            $(pictureId).html('');
                            $(selectable + " > option:selected").each(function () {
                                $(productPicture).append('<img src="' + $(this).data('img-src') + '">');
                                $(pictureId).append('<input type="hidden" name="picture_id[]" value="' + $(this).val() + '">');
                            });
                        } else {
                            $(productPicture).attr('src', '');
                        }
                    });

                    $(pictureModal).find('.product-picture-form').submit(function (e) {
                        e.preventDefault();
                        $('#loading').show();
                        let form_data = new FormData();
                        let ins       = document.getElementById(picture).files.length;
                        for (let x = 0; x < ins; x++) {
                            form_data.append('picture[]', document.getElementById(picture).files[x]);
                        }
                        $.ajax({
                            url: '{{ route('pictures.store') }}',
                            method: 'post',
                            data: form_data,
                            dataType: 'json',
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function (data) {
                                $('#pictures').val('');
                                reloadPictures(selectable, pictureModal, productPicture);
                                showSuccessMessage('Снимките бяха качени успешно!');
                                $('#loading').hide();
                                let picturesNum = $(`${selectable}`).find('option').length - 1;
                                $('.pictures-num').html(`Снимки: ${picturesNum}`);
                            },
                            error: function (data) {
                                $('#loading').hide();
                                showError(data);
                            },
                        })
                    });
                });
            }

            initModal(majorButton, selectable, pictureModal, productPicture, pictureId, picture);
        };

        let a = productPicture('#select-picture-button', '#selectable', '#select-picture-modal', '#product-picture', '#picture-id', 'product-picture-pictures');
        $('#remove-product-picture').click(function () {
            $('#product-picture').html('');
        });

        let b = productPicture('#select-pictures-button', '#selectables', '#select-pictures-modal', '#product-pictures', '#pictures-id', 'product-pictures-pictures');
        $('#remove-product-pictures').click(function () {
            $('#product-pictures').html('');
        });

        $('#category').change(function () {
            $.ajax({
               url:
            });
        });
    </script>
@endpush
