@extends('admin.partials.master')

@section('styles')
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-10">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">{{ $title }}</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form action="" class="form-horizontal">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="title" class="col-sm-2 control-label">Име</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="title" id="title" placeholder="Име">
                                    <span class="error" id="title-error"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="title" class="col-sm-2 control-label">Име</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="title" id="title" placeholder="Име">
                                    <span class="error" id="title-error"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <textarea name="editor" id="editor"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade center" id="myModal" role="dialog">
        </div>
    </div>
@endsection

@push('js')
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script type="text/javascript">
        var editor_config = {
            path_absolute : "{{ URL::to('/') }}/",
            selector: "#editor",
            height: 400,
            fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern codesample"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | fontselect | fontsizeselect | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | code",
            codesample_languages: [
                {text: 'PHP', value: 'php'},
                {text: 'HTML/XML', value: 'markup'},
                {text: 'JavaScript', value: 'javascript'},
                {text: 'CSS', value: 'css'},
                {text: 'MySQL', value: 'sql'},
            ],
            relative_urls: false,
            file_browser_callback : function(field_name, url, type, win) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

                var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
                if (type == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.open({
                    file : cmsURL,
                    title : 'Filemanager',
                    width : x * 0.8,
                    height : y * 0.8,
                    resizable : "yes",
                    close_previous : "no"
                });
            }
        };

        tinyMCE.init(editor_config);

    </script>
@endpush
