<div class="d-flex gap-2">
<button data-id="{{ $item->id }}" class="btn btn-sm btn-primary btn-show"><i class="fa fa-eye"></i></button>
<a href="{{ route('admin.orders.edit', $item->id) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
    <a href="{{ route('admin.orders.destroy', $item->id) }}" class="btn btn-sm btn-danger btn-delete"><i class="fa fa-trash"></i></a>
</div>
