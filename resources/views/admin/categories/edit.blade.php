@include('admin.top-header')

<div class="main-section">
    @include('admin.header')

    <div class="app-content content container-fluid">
        <div class="admin-page">

            <div class="page-header">
                <div>
                    <h1>Edit Category</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        <a href="{{ route('admin.categories.index') }}">Categories</a>
                        <span>›</span> Edit Category
                    </div>
                </div>

                <div class="identity-chip">
                    @if($category->image_url)
                        <img src="{{ $category->image_url }}" class="thumb" alt="{{ $category->name }}">
                    @else
                        <div class="thumb-placeholder"><i class="fa fa-folder"></i></div>
                    @endif
                    <div>
                        <div class="identity-name">{{ $category->name }}</div>
                        <div class="identity-id">ID #{{ $category->id }}</div>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.categories.update', $category->id) }}"
                  enctype="multipart/form-data" data-category-form>
                @csrf
                @method('PUT')

                <input type="hidden" name="redirect" value="{{ $redirect ?? url()->previous() }}">

                @include('admin.categories._form')

                <div class="action-bar">
                    <a href="{{ route('admin.categories.index') }}" class="btn-secondary-dash">Cancel</a>
                    <button type="submit" class="btn-primary-dash" data-submit>
                        <i class="fa fa-save"></i> Update Category
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@include('admin.footer')

<script src="{{ asset('admin/js/category-form.js') }}"></script>