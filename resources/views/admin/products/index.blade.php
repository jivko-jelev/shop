@extends('admin.partials.master')

@section('styles')
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-8">
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
    <script>
        import CKFinder from '@ckeditor/ckeditor5-ckfinder/src/ckfinder';
        ClassicEditor
            .create(document.querySelector('#editor'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
                heading: {
                    options: [
                        {model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph'},
                        {model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1'},
                        {model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2'}
                    ]
                },
                plugins: [ CKFinder ],
            })
            .catch(error => {
                console.log(error);
            });
    </script>
@endpush
