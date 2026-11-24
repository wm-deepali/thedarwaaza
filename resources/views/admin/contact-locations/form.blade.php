@include('admin.top-header')

@php
    $isEdit = isset($location) && $location;
@endphp

<div class="main-section">
    @include('admin.header')

    <div class="app-content content container-fluid">
        <div class="admin-page">

            <div class="page-header">
                <div>
                    <h1>{{ $isEdit ? 'Edit Address' : 'Add Address' }}</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        <a href="{{ route('admin.contact-locations.index') }}">Contact Addresses</a>
                        <span>›</span>
                        {{ $isEdit ? 'Edit' : 'Add' }}
                    </div>
                </div>

                <a href="{{ route('admin.contact-locations.index') }}" class="btn-secondary-dash">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="list-unstyled" style="margin:0;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST"
                action="{{ $isEdit ? route('admin.contact-locations.update', $location->id) : route('admin.contact-locations.store') }}">
                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif

                <div class="form-layout">

                    <div class="section-card">
                        <div class="section-card-header"><h5>Address Details</h5></div>
                        <div class="section-card-body">

                            <div class="field-group">
                                <label class="field-label" for="title">Title <span class="req">*</span></label>
                                <input type="text" id="title" name="title" class="field-input"
                                    value="{{ old('title', $location->title ?? '') }}"
                                    placeholder="e.g. Factory Address, Showroom" maxlength="100" required>
                                @error('title')<div class="field-error">{{ $message }}</div>@enderror
                            </div>

                            <div class="field-group">
                                <label class="field-label" for="address">Address <span class="req">*</span></label>
                                <textarea id="address" name="address" class="field-textarea" rows="5"
                                    maxlength="1000" required>{{ old('address', $location->address ?? '') }}</textarea>
                                <div class="field-hint">Naya line (Enter) contact page par bhi naye line me dikhega.</div>
                                @error('address')<div class="field-error">{{ $message }}</div>@enderror
                            </div>

                        </div>
                    </div>

                    <div class="section-card">
                        <div class="section-card-header"><h5>Settings</h5></div>
                        <div class="section-card-body">

                            <div class="field-group">
                                <label class="field-label" for="sort_order">Sort Order</label>
                                <input type="number" id="sort_order" name="sort_order" class="field-input" min="0"
                                    value="{{ old('sort_order', $location->sort_order ?? 0) }}">
                                <div class="field-hint">Chhota number pehle dikhega.</div>
                                @error('sort_order')<div class="field-error">{{ $message }}</div>@enderror
                            </div>

                            <div class="toggle-row">
                                <div>
                                    <div class="toggle-label">Active</div>
                                    <div class="toggle-sub">Inactive address contact page par nahi dikhega</div>
                                </div>
                                <input type="checkbox" name="status" value="1"
                                    style="width:18px;height:18px;accent-color:var(--accent)"
                                    {{ old('status', $isEdit ? $location->status : true) ? 'checked' : '' }}>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="action-bar">
                    <a href="{{ route('admin.contact-locations.index') }}" class="btn-secondary-dash">Cancel</a>
                    <button type="submit" class="btn-primary-dash">
                        <i class="fa fa-save"></i> {{ $isEdit ? 'Update Address' : 'Save Address' }}
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@include('admin.footer')