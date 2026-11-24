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

            {{-- Messages --}}
            @if(session('success'))
                <div class="alert-box alert-ok">{{ session('success') }}</div>
            @endif
            @if(session('import_errors_only'))
                <div class="alert-box alert-err">{{ session('import_errors_only') }}</div>
            @endif
            @if(!empty(session('import_errors')))
                <div class="alert-box alert-err">
                    <strong>{{ count(session('import_errors')) }} row(s) skipped:</strong>
                    <ul>
                        @foreach(array_slice(session('import_errors'), 0, 20) as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                        @if(count(session('import_errors')) > 20)
                            <li>…and {{ count(session('import_errors')) - 20 }} more</li>
                        @endif
                    </ul>
                </div>
            @endif

            {{-- Add products --}}
            <div class="section-card">
                <div class="section-card-header"><h5>Add Products</h5></div>

                <div class="tabs">
                    <button type="button" class="tab active" data-tab="tab-images">
                        <i class="fa fa-image"></i> Upload images
                    </button>
                    <button type="button" class="tab" data-tab="tab-csv">
                        <i class="fa fa-file-text-o"></i> Import CSV
                    </button>
                </div>

                {{-- Tab 1: images only --}}
                <div class="section-card-body tab-panel active" id="tab-images">
                    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="filter-row">
                            <div class="filter-group" style="min-width:260px">
                                <label>Category <span style="color:var(--red)">*</span></label>
                                <select name="category_id" class="filter-control" required>
                                    <option value="">— Select category —</option>
                                    @foreach($leafCategories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('category_id', request('category_id')) == $cat->id ? 'selected' : '' }}>
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
                                <button type="submit" class="btn-primary-dash"><i class="fa fa-upload"></i> Upload</button>
                            </div>
                        </div>
                        <div class="field-hint">All selected images go into one category. Only categories without sub categories are listed.</div>
                    </form>
                </div>

                {{-- Tab 2: CSV + images --}}
                <div class="section-card-body tab-panel" id="tab-csv">
                    <div class="steps">
                        <div class="step"><span>1</span> Download the template and fill one row per product.</div>
                        <div class="step"><span>2</span> In the <b>image</b> column write the image file name, e.g. <code>door-01.jpg</code>.</div>
                        <div class="step"><span>3</span> Upload the CSV and all the images together.</div>
                    </div>

                    <form method="POST" action="{{ route('admin.products.import') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="filter-row">
                            <div class="filter-group" style="min-width:240px">
                                <label>CSV file <span style="color:var(--red)">*</span></label>
                                <input type="file" name="csv" class="filter-control" style="padding-top:6px" accept=".csv,text/csv" required>
                                @error('csv') <div class="field-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="filter-group" style="flex:1;min-width:240px">
                                <label>Images <span style="color:var(--red)">*</span></label>
                                <input type="file" name="images[]" class="filter-control" style="padding-top:6px"
                                       accept="image/png,image/jpeg,image/webp" multiple required>
                                @error('images.*') <div class="field-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="filter-actions">
                                <a href="{{ route('admin.products.import-template') }}" class="btn-secondary-dash">
                                    <i class="fa fa-download"></i> Template
                                </a>
                                <button type="submit" class="btn-primary-dash"><i class="fa fa-upload"></i> Import</button>
                            </div>
                        </div>
                        <div class="field-hint">
                            Columns: <b>category</b> (id, slug or name), name, <b>image</b>, sort_order, status (1 or 0).
                        </div>
                    </form>
                </div>
            </div>

            {{-- List --}}
            <div class="surface-card">

                <div class="filter-bar">
                    <form method="GET">
                        <div class="filter-row">
                            <div class="filter-group" style="min-width:260px">
                                <label>Show category</label>
                                <select name="category_id" class="filter-control" onchange="this.form.submit()">
                                    <option value="">All categories</option>
                                    @foreach($leafCategories as $cat)
                                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->full_path }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @if(request('category_id'))
                                <div class="filter-actions">
                                    <a href="{{ route('admin.products.index') }}" class="btn-secondary-dash">
                                        <i class="fa fa-refresh"></i> Reset
                                    </a>
                                </div>
                            @endif
                        </div>
                    </form>
                </div>

                @if($products->count())
                    <div class="table-wrap">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name / alt text</th>
                                    <th>Category</th>
                                    <th>Sort</th>
                                    <th>Status</th>
                                    <th style="text-align:right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                    <tr id="product{{ $product->id }}">
                                        <td>
                                            <form id="f{{ $product->id }}" method="POST"
                                                  action="{{ route('admin.products.update', $product->id) }}">
                                                @csrf @method('PUT')
                                            </form>
                                            <img src="{{ $product->image_url }}" class="thumb" alt="{{ $product->name }}">
                                        </td>
                                        <td>
                                            <input type="text" name="name" form="f{{ $product->id }}" class="field-input"
                                                   value="{{ $product->name }}" placeholder="Optional">
                                        </td>
                                        <td>{{ $product->category->name ?? '—' }}</td>
                                        <td>
                                            <input type="number" name="sort_order" form="f{{ $product->id }}"
                                                   class="field-input" style="max-width:80px" min="0"
                                                   value="{{ $product->sort_order }}">
                                        </td>
                                        <td>
                                            <select name="status" form="f{{ $product->id }}" class="field-select-sm">
                                                <option value="1" {{ $product->status ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ !$product->status ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </td>
                                        <td style="text-align:right;white-space:nowrap">
                                            <button type="submit" form="f{{ $product->id }}" class="btn-primary-dash" style="padding:6px 12px">
                                                <i class="fa fa-save"></i> Save
                                            </button>
                                            <button type="button" class="action-btn action-btn-danger"
                                                    onclick="deleteProduct({{ $product->id }})" title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon"><i class="fa fa-image"></i></div>
                        <strong style="font-size:14px">No products found</strong>
                        <p>Use "Add Products" above to upload images or import a CSV.</p>
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
document.querySelectorAll('.tab').forEach(function (tab) {
    tab.addEventListener('click', function () {
        document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
        tab.classList.add('active');
        document.getElementById(tab.dataset.tab).classList.add('active');
    });
});

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