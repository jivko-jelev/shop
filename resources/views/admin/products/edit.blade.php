@extends('admin.partials.master')

@section('styles')
@endsection

@section('content')
    <div class="row">
        <form action="" class="form-horizontal" id="update-product">
            <div class="col-xs-9">
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
                                        <input type="text" class="form-control" name="title" id="title" placeholder="Име"
                                               value="{{ $product->name }}">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default">Запази</button>
                                        </span>
                                    </div>
                                    <span class="error" id="title-error"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="category" class="col-sm-2 control-label">Категория</label>

                                <div class="col-sm-10">
                                    <select class="form-control select2" id="category" name="category">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}"
                                                    @if($category->id==$product->category_id) selected @endif>{{ $category->title }} ({{ $category->alias }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="error" id="category-error"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <textarea name="description" id="description">{{ $product->description }}</textarea>
                                    <span class="error" id="description-error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Снимка</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
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

        $('#update-product').submit(function (e) {
            e.preventDefault();
            $("textarea[name=description]").val(tinyMCE.activeEditor.getContent())
            let form = $(this);
            $.ajax({
                url: "{{ route('products.update', ['product'=>$product]) }}",
                data: form.serialize(),
                method: 'put',
                success: function (data) {
                    Lobibox.notify('success', {
                        msg: 'Продуктът беше обновен успешно'
                    });
                },
                error: function (data) {
                    showErrors(data);
                }
            });
        })
    </script>
@endpush
