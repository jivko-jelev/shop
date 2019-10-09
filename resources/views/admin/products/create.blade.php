@extends('admin.partials.master')

@section('styles')
@endsection

@section('content')
    <div class="row">
        <form action="" class="form-horizontal" id="create-product">
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

                                <div class="col-sm-4">
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
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <textarea name="description" id="description"></textarea>
                                    <span class="error" id="description-error"></span>
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
                        <img src="" alt="" id="product-picture">
                    </div>
                </div>
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Галерия</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                    </div>
                </div>
            </div>
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
                        <h4 class="modal-title">Modal Header</h4>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('pictures.store') }}" method="post" enctype="multipart/form-data" id="product-picture-form">
                            @csrf
                            <input type="file" name="picture[]" id="picture" multiple>
                            <input type="submit" value="Upload Image" name="submit">
                        </form>
                        <select id="selectable">
                        </select>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-default" data-dismiss="modal">Затвори</a>
                        <button type="submit" id="submit" class="btn btn-primary pull-right">Запази</button>
                    </div>
                </div>

            </div>
        </div>
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

        })
        {{--$('#product-picture-form').submit(function (e) {--}}
        {{--    e.preventDefault();--}}
        {{--    let form=$(this);--}}
        {{--    $.ajax({--}}
        {{--        url: "{{ route('pictures.store') }}",--}}
        {{--        data: form.serialize(),--}}
        {{--        method: 'post',--}}
        {{--        success: function (data) {--}}
        {{--        },--}}
        {{--        error: function (data) {--}}
        {{--            showErrors(data);--}}
        {{--        }--}}
        {{--    })--}}
        {{--})--}}


        $('#select-picture-button').click(function (e) {
            $('.selectable').html('')
            $('#select-picture-modal').on('hidden.bs.modal', function () {
                $("#selectable").html('');
            });
            $.ajax({
                method: 'post',
                url: '{{ route('thumbnails.index') }}',
                success: function (data) {
                    $("#selectable").append('<option></option>');
                    for (let i = 0; i < data.length; i++) {
                        if ($('#product-picture').attr('src') != '{{ URL::to('') }}/' + data[i].filename) {
                            $("#selectable").append('<option data-img-src="{{ URL::to('') }}/' + data[i].filename + '"  value="' + data[i].picture_id + '"></option>');
                        } else {
                            $("#selectable").append('<option data-img-src="{{ URL::to('') }}/' + data[i].filename + '"  value="' + data[i].picture_id + '" selected></option>');
                        }
                    }

                    $("#selectable").imagepicker();

                }
            });

            $('#submit').click(function (e) {
                e.preventDefault();
                $('#select-picture-modal').modal('hide');
                if($("#selectable option:selected").data('img-src')) {
                    $('#product-picture').attr('src', $("#selectable option:selected").data('img-src'));
                }else{
                    $('#product-picture').attr('src', '');
                }
            })
        })
    </script>
@endpush
