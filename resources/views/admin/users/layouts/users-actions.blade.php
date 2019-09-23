<a class="btn btn-primary btn-sm a-action" title="Редактирай Потребител" href="{{ route('users.edit', $user) }}" data-toggle="modal" data-target="#myModal">
    <i class="fa fa-pencil"></i>
</a>
<button class="btn btn-danger btn-sm" id="{{ "delete-user-$user->id" }}" title="Изтрий Потребителя">
    <i class="fa fa-trash"></i>
</button>
<script>
    $('#delete-user-{{ $user->id }}').click(function () {
        Lobibox.confirm({
            msg: "Наистина ли искате да изтриете потребителя: <strong>{{ $user->name }}</strong>?",
            callback: function ($this, type) {
                if (type === 'yes') {
                    $.ajax({
                        url: "{{ route('users.destroy', $user) }}",
                        method: 'delete',
                        success: function (data) {
                            Lobibox.notify('success', {
                                msg: 'Потребителят <strong>{{ $user->name }}</strong> беше успешно изтрит.'
                            });
                            table.ajax.reload()
                        }
                    });
                }
            }
        });
    });

</script>
