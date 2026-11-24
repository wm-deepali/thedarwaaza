@include('admin.top-header')

<div class="main-section">
    @include('admin.header')

    <div class="app-content content container-fluid">
        <div class="admin-page">

            <!-- Page header -->
            <div class="page-header">
                <div>
                    <h1>Contact Enquiries
                        @if($unreadCount > 0)
                            <span class="pill-new" style="margin-left:8px">{{ $unreadCount }} new</span>
                        @endif
                    </h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        Contact Enquiries
                    </div>
                </div>

                <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center;">
                    <a href="{{ route('admin.contact-enquiries.export') }}" class="btn-green">
                        <i class="fa fa-file-excel-o"></i> Export Excel
                    </a>
                </div>
            </div>

            <!-- Main card -->
            <div class="surface-card">

                <!-- Bulk action bar -->
                <div class="bulk-bar" id="bulkBar">
                    <span class="bulk-bar-label"><span id="selectedCount">0</span> enquiries selected</span>
                    <button class="btn-danger-dash" onclick="bulkDelete()">
                        <i class="fa fa-trash"></i> Delete Selected
                    </button>
                    <button class="btn-secondary-dash" onclick="clearSelection()">Cancel</button>
                </div>

                <div class="table-wrap">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th style="width:40px"><input type="checkbox" class="check-all" id="checkAll" title="Select all"></th>
                                <th style="width:60px">#</th>
                                <th style="min-width:180px">Customer</th>
                                <th style="width:140px">Phone</th>
                                <th style="min-width:180px">Product</th>
                                <th style="width:160px">Enquiry Type</th>
                                <th style="width:120px">Date</th>
                                <th style="width:80px">Status</th>
                                <th style="width:90px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($enquiries as $item)
                                <tr id="row{{ $item->id }}" class="{{ $item->is_read ? '' : 'is-unread' }}">

                                    <td><input type="checkbox" class="row-check" value="{{ $item->id }}"></td>

                                    <td><span class="id-chip">{{ $enquiries->firstItem() + $loop->index }}</span></td>

                                    <td>
                                        <div class="cust-cell">
                                            <div class="cust-avatar">{{ mb_strtoupper(mb_substr($item->name, 0, 1)) }}</div>
                                            <div>
                                                <div class="cust-name">{{ $item->name }}</div>
                                                <div class="cust-email">{{ $item->email }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td style="color:var(--text-secondary)">{{ $item->phone ?: '—' }}</td>

                                    <td>
                                        @if($item->product)
                                            <div class="prod-cell">
                                                @if($item->product->image_url)
                                                    <img src="{{ $item->product->image_url }}" alt="" class="thumb">
                                                @else
                                                    <div class="thumb-placeholder"><i class="fa fa-image"></i></div>
                                                @endif
                                                <div>
                                                    <div class="prod-name">{{ $item->product->name ?: 'Product #' . $item->product->id }}</div>
                                                    <div class="prod-id">ID: {{ $item->product->id }}</div>
                                                </div>
                                            </div>
                                        @else
                                            <span style="color:var(--text-hint);font-size:12.5px">—</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($item->type)
                                            <span class="inq-tag">{{ $item->type }}</span>
                                        @else
                                            <span style="color:var(--text-hint);font-size:12.5px">—</span>
                                        @endif
                                    </td>

                                    <td class="date-cell">
                                        {{ $item->created_at->format('d M Y') }}
                                        <div style="font-size:11.5px;color:var(--text-hint)">
                                            {{ $item->created_at->format('h:i A') }}
                                        </div>
                                    </td>

                                    <td>
                                        <span class="{{ $item->is_read ? 'pill-read' : 'pill-new' }}">{{ $item->is_read ? 'Read' : 'New' }}</span>
                                    </td>

                                    <td>
                                        <div style="display:flex;gap:6px">
                                            <a href="{{ route('admin.contact-enquiries.show', $item->id) }}"
                                                class="action-btn view" title="View Details">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <button class="action-btn action-btn-danger" title="Delete"
                                                onclick="deleteEnquiry({{ $item->id }})">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9">
                                        <div class="empty-state">
                                            <div class="empty-icon"><i class="fa fa-envelope"></i></div>
                                            <p>No enquiries found. Contact form submissions will appear here.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($enquiries->hasPages())
                    <div class="table-pagination">
                        {{ $enquiries->links('pagination::bootstrap-4') }}
                    </div>
                @endif

            </div>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
    const checkAll = document.getElementById('checkAll');

    function updateBulkBar() {
        const count = document.querySelectorAll('.row-check:checked').length;
        document.getElementById('selectedCount').textContent = count;
        document.getElementById('bulkBar').classList.toggle('visible', count > 0);
    }

    checkAll.addEventListener('change', function () {
        document.querySelectorAll('.row-check').forEach(cb => {
            cb.checked = this.checked;
            cb.closest('tr').classList.toggle('row-selected', this.checked);
        });
        updateBulkBar();
    });

    document.addEventListener('change', function (e) {
        if (!e.target.classList.contains('row-check')) return;

        const all = document.querySelectorAll('.row-check');
        const checked = document.querySelectorAll('.row-check:checked');
        checkAll.indeterminate = checked.length > 0 && checked.length < all.length;
        checkAll.checked = all.length > 0 && checked.length === all.length;
        e.target.closest('tr').classList.toggle('row-selected', e.target.checked);
        updateBulkBar();
    });

    function clearSelection() {
        document.querySelectorAll('.row-check').forEach(cb => {
            cb.checked = false;
            cb.closest('tr').classList.remove('row-selected');
        });
        checkAll.checked = false;
        checkAll.indeterminate = false;
        updateBulkBar();
    }

    function getSelectedIds() {
        return Array.from(document.querySelectorAll('.row-check:checked')).map(cb => cb.value);
    }

    /* ── Single delete ── */
    function deleteEnquiry(id) {
        Swal.fire({
            title: 'Delete Enquiry?',
            text: "This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/contact-enquiries/${id}`,
                    type: "DELETE",
                    data: { _token: "{{ csrf_token() }}" },
                    success: function (res) {
                        Swal.fire('Deleted!', res.message, 'success');
                        $("#row" + id).fadeOut(400, function () { $(this).remove(); });
                    },
                    error: function () {
                        Swal.fire('Error', 'Something went wrong', 'error');
                    }
                });
            }
        });
    }

    /* ── Bulk delete ── */
    function bulkDelete() {
        const ids = getSelectedIds();
        if (!ids.length) return;

        Swal.fire({
            title: `Delete ${ids.length} Enquiries?`,
            text: "This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete All'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.contact-enquiries.bulk-delete') }}",
                    type: "DELETE",
                    data: { _token: "{{ csrf_token() }}", ids: ids },
                    success: function (res) {
                        Swal.fire('Deleted!', res.message, 'success');
                        ids.forEach(id => {
                            $("#row" + id).fadeOut(400, function () { $(this).remove(); });
                        });
                        clearSelection();
                    },
                    error: function () {
                        Swal.fire('Error', 'Something went wrong', 'error');
                    }
                });
            }
        });
    }
</script>