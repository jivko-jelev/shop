@extends('admin.partials.master')

@section('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ URL::to('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-6">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">{{ $category->title }}</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <!-- form start -->
                    <form class="form-horizontal" id="form-category" autocomplete="off" method="post" action="{{ route('categories.update', $category) }}">
                        <div class="form-group">
                            <label for="title" class="col-sm-4 control-label">Име</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="title" id="title" placeholder="Име"
                                       value="{{ old('title', $category->title) }}">
                                <span class="error" id="title-error"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="alias" class="col-sm-4 control-label">Псевдоним</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="alias" id="alias" placeholder="Псевдоним"
                                       value="{{ old('alias', $category->alias) }}">
                                <span class="error" id="alias-error"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="parent_id" class="col-sm-4 control-label">Главна Категория</label>
                            <div class="col-sm-8">
                                <select class="form-control select2" id="parent_id" name="parent_id">
                                    <option value="">Без</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ $cat->id == $category->parent_id ? 'selected' :''  }}>{{ $cat->title }}
                                            ({{ $cat->alias }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @foreach($properties as $property)
                            <hr>
                            <div class="form-group">
                                <label for="property_name[]" class="col-sm-4 control-label">Атрибут</label>

                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="property_name[{{ $property->id }}]"
                                               id="property_name[{{ $property->id }}]" placeholder="Атрибут"
                                               value="{{ $property->name }}">
                                        <span class="input-group-btn">
                                                <button class="btn btn-danger">Изтрий</button>
                                            </span>
                                    </div>
                                    <span class="error" id="alias-error-modal"></span><br>
                                </div>
                            </div>
                            @foreach($property->subProperties as $key => $subProperty)
                                <div class="form-group">
                                    <label for="property_name[]" class="col-sm-4 control-label">Податрибут #{{ $key + 1 }}</label>

                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="subproperty[{{ $subProperty->id }}]"
                                                   id="subproperty[{{ $subProperty->id }}]" placeholder="Атрибут"
                                                   value="{{ $subProperty->name }}">
                                            <span class="input-group-btn">
                                                <button class="btn btn-danger">Изтрий</button>
                                            </span>
                                        </div>
                                        <span class="error" id="alias-error-modal"></span><br>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                        <div class="modal-footer">
                            <!-- /.box-body -->
                            <button type="submit" id="submit" class="btn btn-primary pull-right">Запиши</button>
                            <!-- /.box-footer -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
    </div>
@endsection

@push('js')
    <script>

    </script>
@endpush
