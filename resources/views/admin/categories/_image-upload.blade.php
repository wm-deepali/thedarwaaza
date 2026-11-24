<div data-upload>

    @if(!empty($current))
        <div class="current-image-wrap" data-current>
            <img src="{{ $current }}" alt="">
            <div class="current-image-info">
                <strong>Current image</strong>
                Upload a new file to replace it.
            </div>
        </div>
    @endif

    <div class="file-upload-area" data-area>
        <input type="file" name="{{ $name }}" accept="image/png,image/jpeg,image/webp">
        <div class="upload-icon"><i class="fa fa-cloud-upload"></i></div>
        <p>{{ !empty($current) ? 'Replace image' : 'Click or drag an image here' }}</p>
        <small>{{ $hint ?? '' }} · PNG, JPG, WEBP</small>
    </div>

    <div class="new-preview" data-preview>
        <img src="" alt="Preview" data-preview-img>
        <div>
            <button type="button" data-clear><i class="fa fa-times"></i> Remove</button>
        </div>
    </div>

</div>