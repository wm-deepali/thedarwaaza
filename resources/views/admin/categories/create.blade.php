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

            @php $bulkOpen = $errors->has('names') || old('names'); @endphp

            <div class="tabs" style="border:1px solid var(--border);border-radius:var(--radius-md);margin-bottom:16px">
                <button type="button" class="tab {{ $bulkOpen ? '' : 'active' }}" data-tab="tab-single">
                    <i class="fa fa-folder"></i> Single category
                </button>
                <button type="button" class="tab {{ $bulkOpen ? 'active' : '' }}" data-tab="tab-bulk">
                    <i class="fa fa-list"></i> Add multiple
                </button>
            </div>

            {{-- Tab 1: single (your existing form) --}}
            <div class="tab-panel {{ $bulkOpen ? '' : 'active' }}" id="tab-single">
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

            {{-- Tab 2: many at once --}}
            <div class="tab-panel {{ $bulkOpen ? 'active' : '' }}" id="tab-bulk">
                <form method="POST" action="{{ route('admin.categories.bulk-store') }}">
                    @csrf

                    <div class="section-card">
                        <div class="section-card-header"><h5>Add Multiple Categories</h5></div>
                        <div class="section-card-body">

                            <div class="field-group">
                                <label class="field-label">Category names <span class="req">*</span></label>
                                <textarea name="names" class="field-textarea" rows="10" required
                                          placeholder="Membrane Door&#10;WPC Door&#10;Jali Design&#10;Main Gate">{{ old('names') }}</textarea>
                                <div class="field-hint">One category per line, up to 100. Slug is created from the name.</div>
                                @error('names') <div class="field-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="field-group">
                                <label class="field-label">Parent Category</label>
                                <select name="parent_id" class="field-select">
                                    <option value="">— None (top-level) —</option>
                                    @foreach($parents as $parent)
                                        <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                            {{ $parent->full_path }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="field-hint">All of the categories above are created under this parent.</div>
                                @error('parent_id') <div class="field-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="toggle-row">
                                <div>
                                    <div class="toggle-label">Status</div>
                                    <div class="toggle-sub">Visible on website</div>
                                </div>
                                <select name="status" class="field-select-sm">
                                    <option value="1" {{ old('status', 1) ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ !old('status', 1) ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            <div class="toggle-row">
                                <div>
                                    <div class="toggle-label">Show In Navbar</div>
                                    <div class="toggle-sub">Display in top menu</div>
                                </div>
                                <select name="show_in_navbar" class="field-select-sm">
                                    <option value="0" {{ !old('show_in_navbar', 0) ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ old('show_in_navbar', 0) ? 'selected' : '' }}>Yes</option>
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="action-bar">
                        <a href="{{ route('admin.categories.index') }}" class="btn-secondary-dash">Cancel</a>
                        <button type="submit" class="btn-primary-dash">
                            <i class="fa fa-plus"></i> Add Categories
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

@include('admin.footer')

<script src="{{ asset('admin/js/category-form.js') }}"></script>
<script>
document.querySelectorAll('.tab').forEach(function (tab) {
    tab.addEventListener('click', function () {
        document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
        tab.classList.add('active');
        document.getElementById(tab.dataset.tab).classList.add('active');
    });
});
</script>