<div class="col-xs-6">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{ $category->title }}</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <!-- form start -->
            <form class="form-horizontal" id="form-category" autocomplete="off" method="post"
                  action="{{ route('categories.update', $category) }}">
                <div class="form-group">
                    <label for="title" class="col-sm-4 control-label">Име</label>

                    <div class="col-sm-8 error-div">
                        <input type="text" class="form-control" name="title" id="title" placeholder="Име"
                               value="{{ $category->title }}">
                        <span class="error" id="title-error"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="alias" class="col-sm-4 control-label">Псевдоним</label>

                    <div class="col-sm-8 error-div">
                        <input type="text" class="form-control" name="alias" id="alias" placeholder="Псевдоним"
                               value="{{ $category->alias }}">
                        <span class="error" id="alias-error"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="parent_id" class="col-sm-4 control-label">Главна Категория</label>
                    <div class="col-sm-8 error-div">
                        <select class="form-control select2" id="parent_id" name="parent_id">
                            <option value="">Без</option>
                            @foreach($categories as $cat)
                                <option
                                    value="{{ $cat->id }}" {{ $cat->id == $category->parent_id ? 'selected' :''  }}>{{ $cat->title }}
                                    ({{ $cat->alias }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @foreach($properties as $property)
                    <div class="property" data-id="{{ $property->id }}">
                        <hr>
                        <div class="form-group">
                            <label for="property[]" class="col-sm-4 control-label">Атрибут</label>

                            <div class="col-sm-8 error-div">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="property[{{ $property->id }}]"
                                           id="property[{{ $property->id }}]" placeholder="Атрибут"
                                           value="{{ $property->name }}">
                                    <span class="input-group-btn">
                                                <button type="button" class="btn btn-primary add-property">Добави атрибут</button>
                                                <button type="button" class="btn btn-danger delete-property"
                                                        data-title="{{ $property->name }}" data-saved="1"
                                                        data-route="{{ route('properties.destroy', [$property->id]) }}">Изтрий</button>
                                            </span>
                                </div>
                            </div>
                        </div>
                        @foreach($property->subProperties as $key => $subProperty)
                            <div class="form-group">
                                <label for="subproperty[{{ $subProperty->id }}]" class="col-sm-4 control-label">Податрибут
                                    #{{ $key + 1 }}</label>
                                <div class="col-sm-8 error-div">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="subproperty[{{ $subProperty->id }}]"
                                               id="subproperty[{{ $subProperty->id }}]" placeholder="Податрибут"
                                               value="{{ $subProperty->name }}">
                                        <span class="input-group-btn">
                                                <button type="button" class="btn btn-primary add-subproperty"
                                                        title="Добави податрибут">
                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger delete-subproperty"
                                                        data-title="{{ $subProperty->name }}" data-saved="1"
                                                        title="Изтрий"
                                                        data-route="{{ route('subproperties.destroy', [$subProperty->id]) }}">
                                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                                </button>
                                            </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
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
