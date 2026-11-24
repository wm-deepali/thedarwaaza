@include('admin.top-header')

<div class="main-section">
    @include('admin.header')

    <div class="app-content content container-fluid">
        <div class="admin-page">

            <div class="page-header">
                <div>
                    <h1>Contact Addresses</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        Contact Addresses
                    </div>
                </div>

                <a href="{{ route('admin.contact-locations.create') }}" class="btn-primary-dash">
                    <i class="fa fa-plus"></i> Add Address
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="surface-card">
                <div class="table-wrap">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th style="width:60px">#</th>
                                <th style="width:200px">Title</th>
                                <th>Address</th>
                                <th style="width:90px">Order</th>
                                <th style="width:110px">Status</th>
                                <th style="width:90px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($locations as $item)
                                <tr id="row{{ $item->id }}">
                                    <td><span class="id-chip">{{ $loop->iteration }}</span></td>
                                    <td><strong>{{ $item->title }}</strong></td>
                                    <td style="color:var(--text-secondary)">{!! nl2br(e($item->address)) !!}</td>
                                    <td>{{ $item->sort_order }}</td>
                                    <td>
                                        <span class="pill {{ $item->status ? 'pill-active' : 'pill-inactive' }}">
                                            {{ $item->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div style="display:flex;gap:6px">
                                            <a href="{{ route('admin.contact-locations.edit', $item->id) }}"
                                                class="action-btn" title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <button class="action-btn action-btn-danger" title="Delete"
                                                onclick="deleteLocation({{ $item->id }})">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <div class="empty-icon"><i class="fa fa-map-marker"></i></div>
                                            <p>No addresses yet. Contact page par business address dikhega.</p>
                                            <a href="{{ route('admin.contact-locations.create') }}" class="btn-primary-dash">
                                                <i class="fa fa-plus"></i> Add Address
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
    function deleteLocation(id) {
        Swal.fire({
            title: 'Delete Address?',
            text: "This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/contact-locations/${id}`,
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
</script>