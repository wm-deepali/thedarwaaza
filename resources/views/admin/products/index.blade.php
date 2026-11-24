@include('admin.top-header')

<div class="main-section">
    @include('admin.header')

    <div class="app-content content container-fluid">
        <div class="admin-page">

            <div class="page-header">
                <div>
                    <h1>Products</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span> Manage Products
                    </div>
                </div>
            </div>

            <!-- Bulk upload -->
            <div class="section-card">
                <div class="section-card-header"><h5>Upload Products</h5></div>
                <div class="section-card-body">
                    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="filter-row">

                            <div class="filter-group" style="min-width:260px">
                                <label>Category <span style="color:var(--red)">*</span></label>
                                <select name="category_id" class="filter-control" required>
                                    <option value="">— Select category —</option>
                                    @foreach($leafCategories as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ old('category_id', request('category_id')) == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->full_path }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id') <div class="field-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="filter-group" style="flex:1;min-width:260px">
                                <label>Images <span style="color:var(--red)">*</span></label>
                                <input type="file" name="images[]" class="filter-control" style="padding-top:6px"
                                       accept="image/png,image/jpeg,image/webp" multiple required>
                                @error('images') <div class="field-error">{{ $message }}</div> @enderror
                                @error('images.*') <div class="field-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="filter-actions">
                                <button type="submit" class="btn-primary-dash">
                                    <i class="fa fa-upload"></i> Upload
                                </button>
                            </div>

                        </div>
                        <div class="field-hint">
                            Select many images together. Only categories without sub categories are listed.
                        </div>
                    </form>
                </div>
            </div>

            <!-- List -->
            <div class="surface-card">

                <div class="filter-bar">
                    <form method="GET">
                        <div class="filter-row">
                            <div class="filter-group" style="min-width:260px">
                                <label>Category</label>
                                <select name="category_id" class="filter-control">
                                    <option value="">All</option>
                                    @foreach($leafCategories as $cat)
                                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->full_path }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="filter-actions">
                                <button type="submit" class="btn-primary-dash"><i class="fa fa-filter"></i> Filter</button>
                                <a href="{{ route('admin.products.index') }}" class="btn-secondary-dash">
                                    <i class="fa fa-refresh"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                @if($products->count())
                    <div class="product-grid">
                        @foreach($products as $product)
                            <form method="POST" action="{{ route('admin.products.update', $product->id) }}"
                                  class="product-card" id="product{{ $product->id }}">
                                @csrf
                                @method('PUT')

                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}">

                                <div class="product-card-body">
                                    <small class="field-hint" style="margin:0">{{ $product->category->name ?? '' }}</small>

                                    <input type="text" name="name" class="field-input"
                                           value="{{ $product->name }}" placeholder="Name / alt text (optional)">

                                    <div style="display:flex;gap:8px;align-items:center">
                                        <input type="number" name="sort_order" class="field-input"
                                               style="max-width:80px" min="0" value="{{ $product->sort_order }}" title="Sort order">
                                        <select name="status" class="field-select-sm">
                                            <option value="1" {{ $product->status ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ !$product->status ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>

                                    <div style="display:flex;justify-content:space-between;align-items:center">
                                        <button type="submit" class="btn-primary-dash" style="padding:6px 14px">
                                            <i class="fa fa-save"></i> Save
                                        </button>
                                        <button type="button" class="action-btn action-btn-danger"
                                                onclick="deleteProduct({{ $product->id }})" title="Delete">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon"><i class="fa fa-image"></i></div>
                        <strong style="font-size:14px">No products found</strong>
                        <p>Choose a category above and upload images to get started.</p>
                    </div>
                @endif

                <div class="table-pagination">
                    {{ $products->links('pagination::bootstrap-4') }}
                </div>

            </div>
        </div>
    </div>
</div>

@include('admin.footer')

<script>
function deleteProduct(id) {
    Swal.fire({
        title: 'Delete Product?',
        text: "This action cannot be undone.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#b22222',
        cancelButtonColor: '#6d7175',
        confirmButtonText: 'Yes, Delete'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ url('admin/products') }}/" + id,
                type: "DELETE",
                data: { _token: "{{ csrf_token() }}" },
                beforeSend: function () { Swal.showLoading(); },
                success: function (res) {
                    Swal.fire('Deleted!', res.message, 'success');
                    $("#product" + id).fadeOut(300, function () { $(this).remove(); });
                },
                error: function (xhr) {
                    let msg = (xhr.responseJSON && xhr.responseJSON.message) || 'Something went wrong';
                    Swal.fire('Error!', msg, 'error');
                }
            });
        }
    });
}
</script>