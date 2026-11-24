@include('admin.top-header')

<div class="main-section">
    @include('admin.header')

    <div class="app-content content container-fluid">
        <div class="admin-page">

            <div class="page-header">
                <div>
                    <h1>About Page</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span> About Page
                    </div>
                </div>
                <a href="{{ route('about') }}" target="_blank" class="btn-secondary-dash">
                    <i class="fa fa-external-link"></i> View page
                </a>
            </div>

            @if(session('success'))
                <div class="alert-box alert-ok">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert-box alert-err">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- ───────── Page content ───────── --}}
            <form method="POST" action="{{ route('admin.about-page.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-layout">

                    <div>
                        <div class="section-card">
                            <div class="section-card-header"><h5>Banner &amp; About Text</h5></div>
                            <div class="section-card-body">
                                <div class="field-group">
                                    <label class="field-label">Banner Title</label>
                                    <input type="text" name="banner_title" class="field-input"
                                           value="{{ old('banner_title', $page->banner_title) }}">
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Heading</label>
                                    <input type="text" name="about_heading" class="field-input"
                                           value="{{ old('about_heading', $page->about_heading) }}">
                                </div>
                                <div class="field-group">
                                    <label class="field-label">About Text</label>
                                    <textarea name="about_content" class="field-textarea" rows="12">{{ old('about_content', $page->about_content) }}</textarea>
                                    <div class="field-hint">One paragraph per line.</div>
                                </div>
                            </div>
                        </div>

                        <div class="section-card">
                            <div class="section-card-header"><h5>Why Choose Us (heading)</h5></div>
                            <div class="section-card-body">
                                <div class="field-group">
                                    <label class="field-label">Heading</label>
                                    <input type="text" name="why_heading" class="field-input"
                                           value="{{ old('why_heading', $page->why_heading) }}">
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Intro Text</label>
                                    <textarea name="why_text" class="field-textarea" rows="4">{{ old('why_text', $page->why_text) }}</textarea>
                                    <div class="field-hint">The three cards are managed in the list below.</div>
                                </div>
                            </div>
                        </div>

                        <div class="section-card">
                            <div class="section-card-header"><h5>Brochure Section</h5></div>
                            <div class="section-card-body">
                                <div class="field-group">
                                    <label class="field-label">Heading</label>
                                    <textarea name="brochure_heading" class="field-textarea" rows="2">{{ old('brochure_heading', $page->brochure_heading) }}</textarea>
                                    <div class="field-hint">A new line becomes a line break.</div>
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Text</label>
                                    <input type="text" name="brochure_text" class="field-input"
                                           value="{{ old('brochure_text', $page->brochure_text) }}">
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Brochure File / URL</label>
                                    <input type="text" name="brochure_link" class="field-input"
                                           value="{{ old('brochure_link', $page->brochure_link) }}"
                                           placeholder="pdf/thedarwaaza.pdf">
                                    <div class="field-hint">A path inside the public folder, or a full URL.</div>
                                </div>
                            </div>
                        </div>

                        <div class="section-card">
                            <div class="section-card-header"><h5>Working Process (heading)</h5></div>
                            <div class="section-card-body">
                                <div class="field-group">
                                    <label class="field-label">Heading</label>
                                    <input type="text" name="process_heading" class="field-input"
                                           value="{{ old('process_heading', $page->process_heading) }}">
                                    <div class="field-hint">The four steps are managed in the list below.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="section-card">
                            <div class="section-card-header"><h5>About Image</h5></div>
                            <div class="section-card-body">
                                @if($page->about_image_url)
                                    <div class="current-image-wrap">
                                        <img src="{{ $page->about_image_url }}" alt="">
                                        <div class="current-image-info"><strong>Current image</strong>Upload a new file to replace it.</div>
                                    </div>
                                @endif
                                <input type="file" name="about_image" class="filter-control" style="padding-top:6px;width:100%"
                                       accept="image/png,image/jpeg,image/webp">
                                <div class="field-hint">PNG, JPG or WEBP, up to 4 MB.</div>
                            </div>
                        </div>

                        <div class="section-card">
                            <div class="section-card-header"><h5>Brochure Image</h5></div>
                            <div class="section-card-body">
                                @if($page->brochure_image_url)
                                    <div class="current-image-wrap">
                                        <img src="{{ $page->brochure_image_url }}" alt="">
                                        <div class="current-image-info"><strong>Current image</strong>Upload a new file to replace it.</div>
                                    </div>
                                @endif
                                <input type="file" name="brochure_image" class="filter-control" style="padding-top:6px;width:100%"
                                       accept="image/png,image/jpeg,image/webp">
                                <div class="field-hint">PNG, JPG or WEBP, up to 4 MB.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="action-bar" style="margin-top:0;margin-bottom:24px">
                    <button type="submit" class="btn-primary-dash"><i class="fa fa-save"></i> Save Page Content</button>
                </div>
            </form>

            {{-- ───────── Repeating items ───────── --}}
            @foreach($types as $type => $cfg)
                @php $list = $items->get($type, collect()); @endphp

                <div class="section-card">
                    <div class="section-card-header"><h5>{{ $cfg['label'] }}</h5></div>

                    <div class="section-card-body" style="border-bottom:1px solid var(--border)">
                        <form method="POST" action="{{ route('admin.about-page.items.store') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="type" value="{{ $type }}">

                            <div class="filter-row">
                                @if($cfg['has_image'])
                                    <div class="filter-group" style="flex:1;min-width:220px">
                                        <label>Image <span style="color:var(--red)">*</span></label>
                                        <input type="file" name="image" class="filter-control" style="padding-top:6px"
                                               accept="image/png,image/jpeg,image/webp" required>
                                    </div>
                                @endif

                                @if($cfg['has_icon'])
                                    <div class="filter-group" style="min-width:200px">
                                        <label>Icon class</label>
                                        <input type="text" name="icon" class="filter-control" placeholder="flaticon-people">
                                    </div>
                                @endif

                                <div class="filter-group" style="flex:1;min-width:220px">
                                    <label>Title <span style="color:var(--red)">*</span></label>
                                    <input type="text" name="title" class="filter-control" required>
                                </div>

                                @if($cfg['has_text'])
                                    <div class="filter-group" style="flex:2;min-width:260px">
                                        <label>Text</label>
                                        <input type="text" name="text" class="filter-control">
                                    </div>
                                @endif

                                <div class="filter-group">
                                    <label>Sort</label>
                                    <input type="number" name="sort_order" class="filter-control"
                                           style="min-width:80px;max-width:90px" min="0" placeholder="Auto">
                                </div>

                                <div class="filter-actions">
                                    <button type="submit" class="btn-primary-dash"><i class="fa fa-plus"></i> Add</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    @if($list->count())
                        <div class="table-wrap">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        @if($cfg['has_image']) <th>Image</th> @endif
                                        @if($cfg['has_icon']) <th>Icon class</th> @endif
                                        <th>Title</th>
                                        @if($cfg['has_text']) <th>Text</th> @endif
                                        <th>Sort</th>
                                        <th>Status</th>
                                        <th style="text-align:right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($list as $item)
                                        <tr id="item{{ $item->id }}">
                                            @if($cfg['has_image'])
                                                <td style="min-width:130px">
                                                    <form id="f{{ $item->id }}" method="POST" enctype="multipart/form-data"
                                                          action="{{ route('admin.about-page.items.update', $item->id) }}">
                                                        @csrf @method('PUT')
                                                    </form>
                                                    @if($item->image_url)
                                                        <img src="{{ $item->image_url }}" class="thumb" alt="">
                                                    @endif
                                                    <input type="file" name="image" form="f{{ $item->id }}"
                                                           style="display:block;margin-top:6px;font-size:11px;max-width:140px"
                                                           accept="image/png,image/jpeg,image/webp" title="Replace image">
                                                </td>
                                            @endif

                                            @if($cfg['has_icon'])
                                                <td style="min-width:180px">
                                                    @unless($cfg['has_image'])
                                                        <form id="f{{ $item->id }}" method="POST"
                                                              action="{{ route('admin.about-page.items.update', $item->id) }}">
                                                            @csrf @method('PUT')
                                                        </form>
                                                    @endunless
                                                    <input type="text" name="icon" form="f{{ $item->id }}"
                                                           class="field-input" value="{{ $item->icon }}">
                                                </td>
                                            @endif

                                            <td style="min-width:180px">
                                                <input type="text" name="title" form="f{{ $item->id }}"
                                                       class="field-input" value="{{ $item->title }}" required>
                                            </td>

                                            @if($cfg['has_text'])
                                                <td style="min-width:260px">
                                                    <textarea name="text" form="f{{ $item->id }}" rows="2"
                                                              class="field-textarea" style="min-height:38px">{{ $item->text }}</textarea>
                                                </td>
                                            @endif

                                            <td>
                                                <input type="number" name="sort_order" form="f{{ $item->id }}"
                                                       class="field-input" style="max-width:80px" min="0"
                                                       value="{{ $item->sort_order }}">
                                            </td>
                                            <td>
                                                <select name="status" form="f{{ $item->id }}" class="field-select-sm">
                                                    <option value="1" {{ $item->status ? 'selected' : '' }}>Active</option>
                                                    <option value="0" {{ !$item->status ? 'selected' : '' }}>Inactive</option>
                                                </select>
                                            </td>
                                            <td style="text-align:right;white-space:nowrap">
                                                <button type="submit" form="f{{ $item->id }}" class="btn-primary-dash" style="padding:6px 12px">
                                                    <i class="fa fa-save"></i> Save
                                                </button>
                                                <button type="button" class="action-btn action-btn-danger"
                                                        onclick="deleteItem({{ $item->id }})" title="Delete">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state" style="padding:36px 20px">
                            <p>Nothing here yet. Use the form above to add the first one.</p>
                        </div>
                    @endif
                </div>
            @endforeach

        </div>
    </div>
</div>

@include('admin.footer')

<script>
function deleteItem(id) {
    Swal.fire({
        title: 'Delete this item?',
        text: "This action cannot be undone.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#b22222',
        cancelButtonColor: '#6d7175',
        confirmButtonText: 'Yes, Delete'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ url('admin/about-page/items') }}/" + id,
                type: "DELETE",
                data: { _token: "{{ csrf_token() }}" },
                success: function (res) {
                    Swal.fire('Deleted!', res.message, 'success');
                    $("#item" + id).fadeOut(300, function () { $(this).remove(); });
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