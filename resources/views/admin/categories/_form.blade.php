@php $category = $category ?? null; @endphp

<div class="form-layout">

    <!-- ── LEFT ─────────────────────────────────────────── -->
    <div>

        <div class="section-card">
            <div class="section-card-header"><h5>Basic Information</h5></div>
            <div class="section-card-body">

                <div class="field-group">
                    <label class="field-label">Name <span class="req">*</span></label>
                    <input type="text" name="name" id="name" class="field-input" required
                           value="{{ old('name', $category?->name) }}" placeholder="e.g. Membrane Door">
                    @error('name') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <div class="field-group">
                    <label class="field-label">Slug</label>
                    <div class="slug-wrap">
                        <span class="slug-prefix">/</span>
                        <input type="text" name="slug" id="slug" class="field-input slug-input"
                               value="{{ old('slug', $category?->slug) }}" placeholder="auto-generated">
                    </div>
                    <div class="field-hint">Page URL will be <strong>/your-slug</strong>. Auto-filled from name.</div>
                    @error('slug') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <div class="field-group">
                    <label class="field-label">Parent Category</label>
                    <select name="parent_id" class="field-select">
                        <option value="">— None (top-level) —</option>
                        @foreach($parents as $parent)
                            <option value="{{ $parent->id }}"
                                {{ old('parent_id', $category?->parent_id) == $parent->id ? 'selected' : '' }}>
                                {{ $parent->full_path }}
                            </option>
                        @endforeach
                    </select>
                    <div class="field-hint">Leave blank to create a top-level category.</div>
                    @error('parent_id') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <div class="field-group">
                    <label class="field-label">Sort Order</label>
                    <input type="number" name="sort_order" class="field-input" style="max-width:120px"
                           value="{{ old('sort_order', $category?->sort_order ?? 0) }}" min="0">
                    <div class="field-hint">Lower numbers appear first.</div>
                    @error('sort_order') <div class="field-error">{{ $message }}</div> @enderror
                </div>

            </div>
        </div>

        <div class="section-card">
            <div class="section-card-header"><h5>SEO</h5></div>
            <div class="section-card-body">

                <div class="field-group">
                    <label class="field-label">Meta Title</label>
                    <input type="text" name="meta_title" class="field-input"
                           value="{{ old('meta_title', $category?->meta_title) }}"
                           placeholder="Page title for search engines">
                </div>

                <div class="field-group">
                    <label class="field-label">Meta Description</label>
                    <textarea name="meta_description" class="field-textarea"
                              placeholder="150–160 characters recommended">{{ old('meta_description', $category?->meta_description) }}</textarea>
                </div>

                <div class="field-group">
                    <label class="field-label">Meta Keywords</label>
                    <textarea name="meta_keywords" class="field-textarea"
                              placeholder="Comma separated keywords">{{ old('meta_keywords', $category?->meta_keywords) }}</textarea>
                </div>

                <div class="field-group">
                    <label class="field-label">Canonical URL</label>
                    <input type="text" name="canonical_url" class="field-input"
                           value="{{ old('canonical_url', $category?->canonical_url) }}"
                           placeholder="https://thedarwaaza.com/membrane-door">
                    <div class="field-hint">Leave blank to use the page's own URL.</div>
                    @error('canonical_url') <div class="field-error">{{ $message }}</div> @enderror
                </div>

            </div>
        </div>

    </div>

    <!-- ── RIGHT ────────────────────────────────────────── -->
    <div>

        <div class="section-card">
            <div class="section-card-header"><h5>Card Image</h5></div>
            <div class="section-card-body">
                @include('admin.categories._image-upload', [
                    'name'    => 'image',
                    'current' => $category?->image_url,
                    'hint'    => 'Shown on the parent category page',
                ])
                @error('image') <div class="field-error">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="section-card">
            <div class="section-card-header"><h5>Banner Image</h5></div>
            <div class="section-card-body">
                @include('admin.categories._image-upload', [
                    'name'    => 'banner_image',
                    'current' => $category?->banner_url,
                    'hint'    => 'Top banner of this category page',
                ])
                @error('banner_image') <div class="field-error">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="section-card">
            <div class="section-card-header"><h5>Settings</h5></div>
            <div class="section-card-body" style="padding:16px 20px">

                <div class="toggle-row">
                    <div>
                        <div class="toggle-label">Status</div>
                        <div class="toggle-sub">Visible on website</div>
                    </div>
                    <select name="status" class="field-select-sm">
                        <option value="1" {{ old('status', $category?->status ?? 1) ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ !old('status', $category?->status ?? 1) ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="toggle-row">
                    <div>
                        <div class="toggle-label">Show In Navbar</div>
                        <div class="toggle-sub">Display in top menu</div>
                    </div>
                    <select name="show_in_navbar" class="field-select-sm">
                        <option value="0" {{ !old('show_in_navbar', $category?->show_in_navbar ?? 0) ? 'selected' : '' }}>No</option>
                        <option value="1" {{ old('show_in_navbar', $category?->show_in_navbar ?? 0) ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>

            </div>
        </div>

    </div>
</div>