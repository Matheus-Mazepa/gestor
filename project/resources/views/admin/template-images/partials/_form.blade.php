@csrf
<div class="form-group">
    <label for="title">
        @lang('labels.template_images.title')
    </label>
    <input
            type="text"
            name="title"
            class="form-control {{ has_error_class('title') }}"
            id="title"
            placeholder="@lang('placeholders.template_images.title')"
            value="{{old('title') ?? $user->title ?? ''}}">
    @errorblock('title')
</div>

<div class="form-group">
    <label form="html">
        @lang('labels.template_images.html')
    </label>
    <div class="input-group">
        <input-file
                id="html"
                name="html"
                placeholder="@lang('placeholders.template_images.html')"
                errors="{{ $errors }}">
        </input-file>
        @errorblock('html')
    </div>
</div>
