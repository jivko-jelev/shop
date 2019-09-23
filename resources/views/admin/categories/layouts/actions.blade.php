<a class="btn btn-primary btn-sm a-action" title="Редактирай Категорията" href="{{ route('categories.edit', $category) }}" data-toggle="modal" data-target="#myModal">
    <i class="fa fa-pencil"></i>
</a>
<button class="btn btn-danger btn-sm" id="{{ "delete-category-$category->id" }}" title="Изтрий Категорията">
    <i class="fa fa-trash"></i>
</button>
<script>
    $('#delete-category-{{ $category->id }}').click(function () {
        Lobibox.confirm({
            msg: "Наистина ли искате да изтриете категорията: <strong>{{ $category->title }}</strong>?",
            callback: function ($this, type) {
                if (type === 'yes') {
                    $.ajax({
                        url: "{{ route('categories.destroy', $category) }}",
                        method: 'delete',
                        success: function (data) {
                            Lobibox.notify('success', {
                                msg: 'Категорията <strong>{{ $category->title }}</strong> беше успешно изтрита'
                            });
                            table.ajax.reload()
                        }
                    });
                }
            }
        });
    });
</script>
