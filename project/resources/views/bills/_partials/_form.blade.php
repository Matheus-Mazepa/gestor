@csrf
<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label for="description">
                @lang('labels.common.description')
            </label>
            <input
                    type="text"
                    name="description"
                    class="form-control {{ has_error_class('description') }}"
                    id="description"
                    placeholder="@lang('placeholders.common.description')"
                    value="{{old('description') ?? $bill->description ?? ''}}">
            @errorblock('description')
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label for="title">
                @lang('labels.common.title')
            </label>
            <input
                    type="text"
                    name="title"
                    class="form-control {{ has_error_class('title') }}"
                    id="title"
                    placeholder="@lang('placeholders.products.title')"
                    value="{{old('title') ?? $product->title ?? ''}}">
            @errorblock('title')
        </div>
    </div>
</div>