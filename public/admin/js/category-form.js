(function () {
    // ── Slug auto-generate (stops once slug is edited by hand / already filled)
    var nameInput = document.getElementById('name');
    var slugInput = document.getElementById('slug');

    if (nameInput && slugInput) {
        var manualSlug = slugInput.value.trim() !== '';

        slugInput.addEventListener('keyup', function () { manualSlug = true; });

        nameInput.addEventListener('keyup', function () {
            if (manualSlug) return;
            slugInput.value = nameInput.value
                .toLowerCase()
                .trim()
                .replace(/\s+/g, '-')
                .replace(/[^\w-]+/g, '');
        });
    }

    // ── Image previews (works for every [data-upload] block)
    document.querySelectorAll('[data-upload]').forEach(function (block) {
        var input   = block.querySelector('input[type=file]');
        var area    = block.querySelector('[data-area]');
        var preview = block.querySelector('[data-preview]');
        var img     = block.querySelector('[data-preview-img]');
        var current = block.querySelector('[data-current]');
        var clear   = block.querySelector('[data-clear]');

        input.addEventListener('change', function () {
            var file = this.files[0];
            if (!file) return;

            var reader = new FileReader();
            reader.onload = function (e) {
                img.src = e.target.result;
                preview.style.display = 'block';
                area.style.display = 'none';
                if (current) current.style.display = 'none';
            };
            reader.readAsDataURL(file);
        });

        clear.addEventListener('click', function () {
            input.value = '';
            preview.style.display = 'none';
            area.style.display = 'block';
            if (current) current.style.display = 'flex';
        });
    });

    // ── Disable submit button + spinner
    var form = document.querySelector('form[data-category-form]');
    if (form) {
        form.addEventListener('submit', function () {
            var btn = form.querySelector('[data-submit]');
            if (!btn) return;
            btn.disabled = true;
            btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Saving…';
        });
    }
})();