@csrf
<div class="form-group">
    <label for="title">
        @lang('labels.products.title')
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

<div class="form-group">
    <label for="description">
        @lang('labels.products.description')
    </label>
    <input
            type="text"
            name="description"
            class="form-control {{ has_error_class('description') }}"
            id="description"
            placeholder="@lang('placeholders.products.description')"
            value="{{old('description') ?? $product->description ?? ''}}">
    @errorblock('description')
</div>

<div class="form-group">
    <label for="ncm">
        @lang('labels.products.ncm')
    </label>
    <input
            type="text"
            name="ncm"
            class="form-control {{ has_error_class('ncm') }}"
            id="ncm"
            placeholder="@lang('placeholders.products.ncm')"
            value="{{old('ncm') ?? $product->ncm ?? ''}}">
    @errorblock('ncm')
</div>

<div class="form-group">
    <label for="code">
        @lang('labels.products.code')
    </label>
    <input
            type="text"
            name="code"
            class="form-control {{ has_error_class('code') }}"
            id="code"
            placeholder="@lang('placeholders.products.code')"
            value="{{old('code') ?? $product->code ?? ''}}">
    @errorblock('code')
</div>

<div class="form-group">
    <label for="price_nfe">
        @lang('labels.products.price_nfe')
    </label>
    <input
            type="text"
            name="price_nfe"
            class="form-control {{ has_error_class('price_nfe') }}"
            id="price_nfe"
            placeholder="@lang('placeholders.products.price_nfe')"
            value="{{old('price_nfe') ?? $product->price_nfe ?? ''}}">
    @errorblock('price_nfe')
</div>

<div class="form-group">
    <label for="commercial_unit">
        @lang('labels.products.commercial_unit')
    </label>
    <input
            type="text"
            name="commercial_unit"
            class="form-control {{ has_error_class('commercial_unit') }}"
            id="commercial_unit"
            placeholder="@lang('placeholders.products.commercial_unit')"
            value="{{old('commercial_unit') ?? $product->commercial_unit ?? ''}}">
    @errorblock('commercial_unit')
</div>