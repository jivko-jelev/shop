<a class="btn btn-primary btn-sm a-action" title="Бързо редактиране на категорията" href="{{ route('categories.edit', $category) }}" data-toggle="modal"
   data-target="#myModal">
    <i class="fa fa-pencil"></i>
</a>
<a class="btn btn-success btn-sm" title="Редактирай Категорията" href="{{ route('categories.full.edit', $category) }}"><i class="fa fa-pencil"></i></a>
<button class="btn btn-danger btn-sm delete-category" data-route="{{ route('categories.destroy', $category) }}" data-title="{{ $category->title }}"
        title="Изтрий Категорията">
    <i class="fa fa-trash"></i>
</button>