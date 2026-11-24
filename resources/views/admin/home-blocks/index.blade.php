@include('admin.top-header')

<div class="main-section">
    @include('admin.header')

    <div class="app-content content container-fluid">
        <div class="admin-page">

            <div class="page-header">
                <div>
                    <h1>Home Page</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span> Home Page Sections
                    </div>
                </div>
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

            {{-- Add --}}
            <div class="section-card">
                <div class="section-card-header"><h5>Add to {{ $cfg['label'] }}</h5></div>
                <div class="section-card-body">
                    <form method="POST" action="{{ route('admin.home-blocks.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="section" value="{{ $section }}">

                        <div class="filter-row">
                            <div class="filter-group" style="flex:1;min-width:240px">
                                <label>Image <span style="color:var(--red)">*</span></label>
                                <input type="file" name="image" class="filter-control" style="padding-top:6px"
                                       accept="image/png,image/jpeg,image/webp" required>
                            </div>

                            <div class="filter-group" style="flex:1;min-width:240px">
                                <label>{{ $cfg['title'] }}</label>
                                <textarea name="title" rows="2" class="field-textarea" style="min-height:38px">{{ old('title') }}</textarea>
                            </div>

                            @if($cfg['subtitle'])
                                <div class="filter-group" style="flex:1;min-width:240px">
                                    <label>{{ $cfg['subtitle'] }}</label>
                                    <input type="text" name="subtitle" class="filter-control" value="{{ old('subtitle') }}">
                                </div>
                            @endif

                            @if($cfg['link'])
                                <div class="filter-group" style="flex:1;min-width:240px">
                                    <label>Link</label>
                                    <input type="text" name="link" class="filter-control" value="{{ old('link') }}"
                                           placeholder="/category/front-door">
                                </div>
                            @endif

                            <div class="filter-group">
                                <label>Sort</label>
                                <input type="number" name="sort_order" class="filter-control" style="min-width:80px;max-width:90px"
                                       min="0" value="{{ old('sort_order') }}" placeholder="Auto">
                            </div>

                            <div class="filter-group">
                                <label>Status</label>
                                <select name="status" class="filter-control" style="min-width:110px">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                            <div class="filter-actions">
                                <button type="submit" class="btn-primary-dash"><i class="fa fa-plus"></i> Add</button>
                            </div>
                        </div>
                        <div class="field-hint">{{ $cfg['hint'] }} PNG, JPG or WEBP, up to 4 MB.</div>
                    </form>
                </div>
            </div>

            {{-- List --}}
            <div class="surface-card">

                <div class="tabs">
                    @foreach($sections as $key => $s)
                        <a href="{{ route('admin.home-blocks.index', ['section' => $key]) }}"
                           class="tab {{ $section === $key ? 'active' : '' }}">
                            {{ $s['label'] }}
                            <span class="tab-count">{{ $counts[$key] ?? 0 }}</span>
                        </a>
                    @endforeach
                </div>

                @if($blocks->count())
                    <div class="table-wrap">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>{{ $cfg['title'] }}</th>
                                    @if($cfg['subtitle']) <th>{{ $cfg['subtitle'] }}</th> @endif
                                    @if($cfg['link']) <th>Link</th> @endif
                                    <th>Sort</th>
                                    <th>Status</th>
                                    <th style="text-align:right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($blocks as $block)
                                    <tr id="block{{ $block->id }}">
                                        <td style="min-width:150px">
                                            <form id="f{{ $block->id }}" method="POST" enctype="multipart/form-data"
                                                  action="{{ route('admin.home-blocks.update', $block->id) }}">
                                                @csrf @method('PUT')
                                            </form>
                                            @if($block->image_url)
                                                <img src="{{ $block->image_url }}" class="thumb"
                                                     style="width:96px;height:56px" alt="">
                                            @endif
                                            <input type="file" name="image" form="f{{ $block->id }}"
                                                   style="display:block;margin-top:6px;font-size:11px;max-width:150px"
                                                   accept="image/png,image/jpeg,image/webp" title="Replace image">
                                        </td>
                                        <td style="min-width:200px">
                                            <textarea name="title" form="f{{ $block->id }}" rows="2"
                                                      class="field-textarea" style="min-height:38px">{{ $block->title }}</textarea>
                                        </td>
                                        @if($cfg['subtitle'])
                                            <td style="min-width:200px">
                                                <input type="text" name="subtitle" form="f{{ $block->id }}"
                                                       class="field-input" value="{{ $block->subtitle }}">
                                            </td>
                                        @endif
                                        @if($cfg['link'])
                                            <td style="min-width:200px">
                                                <input type="text" name="link" form="f{{ $block->id }}"
                                                       class="field-input" value="{{ $block->link }}">
                                            </td>
                                        @endif
                                        <td>
                                            <input type="number" name="sort_order" form="f{{ $block->id }}"
                                                   class="field-input" style="max-width:80px" min="0"
                                                   value="{{ $block->sort_order }}">
                                        </td>
                                        <td>
                                            <select name="status" form="f{{ $block->id }}" class="field-select-sm">
                                                <option value="1" {{ $block->status ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ !$block->status ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </td>
                                        <td style="text-align:right;white-space:nowrap">
                                            <button type="submit" form="f{{ $block->id }}" class="btn-primary-dash" style="padding:6px 12px">
                                                <i class="fa fa-save"></i> Save
                                            </button>
                                            <button type="button" class="action-btn action-btn-danger"
                                                    onclick="deleteBlock({{ $block->id }})" title="Delete">
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
                        <strong style="font-size:14px">Nothing here yet</strong>
                        <p>Use the form above to add the first one.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
function deleteBlock(id) {
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
                url: "{{ url('admin/home-blocks') }}/" + id,
                type: "DELETE",
                data: { _token: "{{ csrf_token() }}" },
                success: function (res) {
                    Swal.fire('Deleted!', res.message, 'success');
                    $("#block" + id).fadeOut(300, function () { $(this).remove(); });
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