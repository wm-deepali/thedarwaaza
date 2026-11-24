@include('admin.top-header')

<div class="main-section">
    @include('admin.header')

    <div class="app-content content container-fluid">
        <div class="admin-page">

            <div class="page-header">
                <div>
                    <h1>Categories</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span> Manage Categories
                    </div>
                </div>

                <a href="{{ route('admin.categories.create') }}" class="btn-primary-dash">
                    <i class="fa fa-plus"></i> Add Category
                </a>
            </div>

            <div class="surface-card">

                <!-- Filters -->
                <div class="filter-bar">
                    <form method="GET">
                        <div class="filter-row">

                            <div class="filter-group">
                                <label>Type</label>
                                <select name="type" id="typeFilter" class="filter-control">
                                    <option value="">All</option>
                                    <option value="category"    {{ request('type') == 'category'    ? 'selected' : '' }}>Top-level</option>
                                    <option value="subcategory" {{ request('type') == 'subcategory' ? 'selected' : '' }}>Sub Categories</option>
                                </select>
                            </div>

                            <div class="filter-group" id="categoryFilterDiv"
                                 style="{{ request('type') == 'subcategory' ? '' : 'display:none;' }}">
                                <label>Parent Category</label>
                                <select name="category_id" class="filter-control">
                                    <option value="">All</option>
                                    @foreach($parentCategories as $parent)
                                        <option value="{{ $parent->id }}"
                                            {{ request('category_id') == $parent->id ? 'selected' : '' }}>
                                            {{ $parent->full_path }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="filter-group" style="flex:1">
                                <label>Search</label>
                                <input type="text" name="search" value="{{ request('search') }}"
                                       class="filter-control filter-control-wide"
                                       placeholder="Search category name…">
                            </div>

                            <div class="filter-actions">
                                <button type="submit" class="btn-primary-dash">
                                    <i class="fa fa-search"></i> Search
                                </button>
                                <a href="{{ route('admin.categories.index') }}" class="btn-secondary-dash">
                                    <i class="fa fa-refresh"></i> Reset
                                </a>
                            </div>

                        </div>
                    </form>
                </div>

                @php
                    $sortUrl = function ($column) {
                        $dir = request('sort_by') == $column && request('sort_order') == 'asc' ? 'desc' : 'asc';
                        return request()->fullUrlWithQuery(['sort_by' => $column, 'sort_order' => $dir]);
                    };
                    $sortIcon = function ($column) {
                        if (request('sort_by') != $column) return '<i class="fa fa-sort"></i>';
                        return request('sort_order') == 'asc'
                            ? '<i class="fa fa-sort-up" style="color:var(--accent)"></i>'
                            : '<i class="fa fa-sort-down" style="color:var(--accent)"></i>';
                    };
                @endphp

                <!-- Table -->
                <div class="table-wrap">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th><a href="{{ $sortUrl('id') }}" class="sort-link">ID {!! $sortIcon('id') !!}</a></th>
                                <th>Image</th>
                                <th><a href="{{ $sortUrl('name') }}" class="sort-link">Name {!! $sortIcon('name') !!}</a></th>
                                <th>Parent</th>
                                <th><a href="{{ $sortUrl('show_in_navbar') }}" class="sort-link">Navbar {!! $sortIcon('show_in_navbar') !!}</a></th>
                                <th><a href="{{ $sortUrl('sort_order') }}" class="sort-link">Sort {!! $sortIcon('sort_order') !!}</a></th>
                                <th><a href="{{ $sortUrl('status') }}" class="sort-link">Status {!! $sortIcon('status') !!}</a></th>
                                <th style="width:120px">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($categories as $cat)
                                <tr id="row{{ $cat->id }}">
                                    <td><span class="id-chip">{{ $cat->id }}</span></td>

                                    <td>
                                        @if($cat->image_url)
                                            <img src="{{ $cat->image_url }}" class="thumb" alt="{{ $cat->name }}">
                                        @else
                                            <div class="thumb-placeholder"><i class="fa fa-image"></i></div>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="name-cell">
                                            <strong>{{ $cat->name }}</strong>
                                            <small>/{{ $cat->slug }} · {{ $cat->children_count }} sub categories</small>
                                        </div>
                                    </td>

                                    <td style="color:var(--text-secondary)">{{ $cat->parent->name ?? '—' }}</td>

                                    <td>
                                        {!! $cat->show_in_navbar
                                            ? '<span class="pill pill-yes">Yes</span>'
                                            : '<span class="pill pill-no">No</span>' !!}
                                    </td>

                                    <td><strong>{{ $cat->sort_order }}</strong></td>

                                    <td>
                                        {!! $cat->status
                                            ? '<span class="pill pill-active">Active</span>'
                                            : '<span class="pill pill-inactive">Inactive</span>' !!}
                                    </td>

                                    <td>
                                        <div style="display:flex;gap:6px">
                                            <a href="{{ url($cat->slug) }}" target="_blank" class="action-btn" title="View on site">
                                                <i class="fa fa-external-link"></i>
                                            </a>
                                            <a href="{{ route('admin.categories.edit', ['category' => $cat->id, 'redirect' => request()->fullUrl()]) }}"
                                               class="action-btn" title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <button class="action-btn action-btn-danger"
                                                    onclick="deleteCategory({{ $cat->id }})" title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <div class="empty-state">
                                            <div class="empty-icon"><i class="fa fa-folder-open"></i></div>
                                            <strong style="font-size:14px">No categories found</strong>
                                            <p>Try adjusting your filters or add a new category.</p>
                                            <a href="{{ route('admin.categories.create') }}" class="btn-primary-dash">
                                                <i class="fa fa-plus"></i> Add Category
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="table-pagination">
                    {{ $categories->links('pagination::bootstrap-4') }}
                </div>

            </div>
        </div>
    </div>
</div>

@include('admin.footer')

<script>
function deleteCategory(id) {
    Swal.fire({
        title: 'Delete Category?',
        text: "This action cannot be undone.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#b22222',
        cancelButtonColor: '#6d7175',
        confirmButtonText: 'Yes, Delete'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ url('admin/categories') }}/" + id,
                type: "DELETE",
                data: { _token: "{{ csrf_token() }}" },
                beforeSend: function () { Swal.showLoading(); },
                success: function (res) {
                    Swal.fire('Deleted!', res.message, 'success');
                    $("#row" + id).fadeOut(300, function () { $(this).remove(); });
                },
                error: function (xhr) {
                    let msg = (xhr.responseJSON && xhr.responseJSON.message) || 'Something went wrong';
                    Swal.fire('Error!', msg, 'error');
                }
            });
        }
    });
}

document.getElementById('typeFilter').addEventListener('change', function () {
    document.getElementById('categoryFilterDiv').style.display = this.value === 'subcategory' ? '' : 'none';
});
</script>