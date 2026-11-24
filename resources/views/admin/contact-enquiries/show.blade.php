@include('admin.top-header')

<div class="main-section">

    @include('admin.header')

    <div class="app-content content container-fluid">
        <div class="admin-page">

            <!-- Page Header -->
            <div class="page-header">
                <div>
                    <h1>Contact Enquiry Details</h1>

                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        <a href="{{ route('admin.contact-enquiries.index') }}">Contact Enquiries</a>
                        <span>›</span>
                        View Enquiry
                    </div>
                </div>

                <a href="{{ route('admin.contact-enquiries.index') }}" class="btn-secondary-dash">
                    <i class="fa fa-arrow-left"></i>
                    Back
                </a>
            </div>

            <div class="surface-card">

                <div class="p-4">

                    <div class="row mb-4">
                        <div class="col-md-3"><strong>Name</strong></div>
                        <div class="col-md-9">{{ $enquiry->name }}</div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-3"><strong>Email</strong></div>
                        <div class="col-md-9"><a href="mailto:{{ $enquiry->email }}">{{ $enquiry->email }}</a></div>
                    </div>

                    @if($enquiry->phone)
                        <div class="row mb-4">
                            <div class="col-md-3"><strong>Phone</strong></div>
                            <div class="col-md-9">
                                <a href="tel:{{ preg_replace('/[^\d+]/', '', $enquiry->phone) }}">{{ $enquiry->phone }}</a>
                            </div>
                        </div>
                    @endif

                    @if($enquiry->product)
                        <div class="row mb-4">
                            <div class="col-md-3"><strong>Product</strong></div>
                            <div class="col-md-9">
                                <div class="prod-cell">
                                    @if($enquiry->product->image_url)
                                        <img src="{{ $enquiry->product->image_url }}" alt="" class="thumb"
                                            style="width:56px;height:56px">
                                    @endif
                                    <div>
                                        <div class="prod-name">{{ $enquiry->product->name ?: 'Product #' . $enquiry->product->id }}</div>
                                        <div class="prod-id">ID: {{ $enquiry->product->id }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-3"><strong>Enquiry Type</strong></div>
                        <div class="col-md-9">
                            <span class="inq-tag">{{ $enquiry->type ?: 'General' }}</span>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-3"><strong>Submitted On</strong></div>
                        <div class="col-md-9">
                            {{ $enquiry->created_at->format('d M Y') }}
                            <div class="text-muted small">{{ $enquiry->created_at->format('h:i A') }}</div>
                        </div>
                    </div>

                    @if($enquiry->ip_address)
                        <div class="row mb-4">
                            <div class="col-md-3"><strong>IP Address</strong></div>
                            <div class="col-md-9 text-muted">{{ $enquiry->ip_address }}</div>
                        </div>
                    @endif

                    @if($enquiry->message)
                        <div class="row mb-4">
                            <div class="col-md-3"><strong>Message</strong></div>
                            <div class="col-md-9">
                                <div class="border rounded p-3 bg-light">{!! nl2br(e($enquiry->message)) !!}</div>
                            </div>
                        </div>
                    @endif

                    @php
                        $wa = preg_replace('/\D/', '', (string) $enquiry->phone);
                        if (strlen($wa) === 10) {
                            $wa = '91' . $wa;
                        }
                        $replySubject = $enquiry->product
                            ? 'Re: your enquiry about ' . ($enquiry->product->name ?: 'our product')
                            : 'Re: your enquiry';
                    @endphp
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-9" style="display:flex;gap:8px;flex-wrap:wrap">
                            <a href="mailto:{{ $enquiry->email }}?subject={{ rawurlencode($replySubject) }}"
                                class="btn-secondary-dash">
                                <i class="fa fa-envelope"></i> Reply by Email
                            </a>
                            @if(strlen($wa) >= 10)
                                <a href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener"
                                    class="btn-secondary-dash">
                                    <i class="fa-brands fa-whatsapp"></i> WhatsApp
                                </a>
                            @endif
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>

@include('admin.footer')