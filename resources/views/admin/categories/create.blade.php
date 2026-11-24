@include('admin.top-header')

<div class="main-section">
    @include('admin.header')

    <div class="app-content content container-fluid">
        <div class="admin-page">

            <div class="page-header">
                <div>
                    <h1>Add Category</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        <a href="{{ route('admin.categories.index') }}">Categories</a>
                        <span>›</span> Add Category
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.categories.store') }}"
                  enctype="multipart/form-data" data-category-form>
                @csrf

                @include('admin.categories._form', ['category' => null])

                <div class="action-bar">
                    <a href="{{ route('admin.categories.index') }}" class="btn-secondary-dash">Cancel</a>
                    <button type="submit" class="btn-primary-dash" data-submit>
                        <i class="fa fa-save"></i> Save Category
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@include('admin.footer')

<script src="{{ asset('admin/js/category-form.js') }}"></script>