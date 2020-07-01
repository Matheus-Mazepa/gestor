@csrf
<div class="row">
    <div class="form-group col-sm-12 col-md-4">
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

    <div class="form-group col-sm-12 col-md-4">
        <label for="permissions">
            @lang('labels.products.category')
        </label>
        <custom-select
                name="category_id"
                class="form-group {{ has_error_class('category_id') }}"
                :old='@json(old())'
                @if (isset($product))
                :selected="{{ $product->category_id }}"
                @endif
                placeholder="@lang('placeholders.products.category')"
                :options="{{ collect($categories) }}"
        ></custom-select>
        @errorblock('category_id')
    </div>

    <div class="form-group col-sm-12 col-md-4">
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
</div>

<div class="row">
    <div class="form-group col-sm-12 col-md-6">
        <label for="ncm">
            @lang('labels.products.ncm')
        </label>
        <input
                type="text"
                name="ncm"
                class="form-control mask-number {{ has_error_class('ncm') }}"
                id="ncm"
                placeholder="@lang('placeholders.products.ncm')"
                value="{{old('ncm') ?? $product->ncm ?? ''}}">
        @errorblock('ncm')
    </div>

    <div class="form-group col-sm-12 col-md-6">
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
</div>

<div class="row">
    <div class="form-group col-sm-12 col-md-6">
        <label for="price_nfe">
            @lang('labels.products.price_nfe')
        </label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">R$</span>
            </div>
            <input
                    type="text"
                    name="price_nfe"
                    class="form-control mask-money  {{ has_error_class('price_nfe') }}"
                    id="price_nfe"
                    placeholder="@lang('placeholders.products.price_nfe')"
                    value="{{old('price_nfe') ?? $product->price_nfe ?? ''}}">
        </div>
        @errorblock('price_nfe')
    </div>

    <div class="form-group col-sm-12 col-md-6">
        <label for="price_nfc">
            @lang('labels.products.price_nfc')
        </label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">R$</span>
            </div>
            <input
                    type="text"
                    name="price_nfc"
                    class="form-control mask-money  {{ has_error_class('price_nfc') }}"
                    id="price_nfc"
                    placeholder="@lang('placeholders.products.price_nfc')"
                    value="{{old('price_nfc') ?? $product->price_nfc ?? ''}}">
        </div>
        @errorblock('price_nfc')
    </div>
</div>

<div class="row">
    <div class="form-group col-sm-12 col-md-6">
        <label for="cfop_nfe">
            @lang('labels.products.cfop_nfe')
        </label>
        <input
                type="text"
                name="cfop_nfe"
                class="form-control mask-number {{ has_error_class('cfop_nfe') }}"
                id="cfop_nfe"
                placeholder="@lang('placeholders.products.cfop_nfe')"
                value="{{old('cfop_nfe') ?? $product->cfop_nfe ?? ''}}">
        @errorblock('cfop_nfe')
    </div>

    <div class="form-group col-sm-12 col-md-6">
        <label for="cfop_nfc">
            @lang('labels.products.cfop_nfc')
        </label>
        <input
                type="text"
                name="cfop_nfc"
                class="form-control mask-number {{ has_error_class('cfop_nfc') }}"
                id="cfop_nfc"
                placeholder="@lang('placeholders.products.cfop_nfc')"
                value="{{old('cfop_nfc') ?? $product->cfop_nfc ?? ''}}">
        @errorblock('cfop_nfc')
    </div>
</div>

<div class="row">
    <div class="form-group col-sm-12 col-md-6">
        <label for="cfop_nfe">
            @lang('labels.products.minimal_quantity')
        </label>
        <input
                type="text"
                name="minimal_quantity"
                class="form-control mask-number {{ has_error_class('minimal_quantity') }}"
                id="minimal_quantity"
                placeholder="@lang('placeholders.products.minimal_quantity')"
                value="{{old('minimal_quantity') ?? $product->minimal_quantity ?? ''}}">
        @errorblock('minimal_quantity')
    </div>

    <div class="form-group col-sm-12 col-md-6">
        <label for="taxable_quantity">
            @lang('labels.products.taxable_quantity')
        </label>
        <input
                type="number"
                name="taxable_quantity"
                class="form-control {{ has_error_class('taxable_quantity') }}"
                id="taxable_quantity"
                placeholder="@lang('placeholders.products.taxable_quantity')"
                value="{{old('taxable_quantity') ?? $product->taxable_quantity ?? ''}}">
        @errorblock('taxable_quantity')
    </div>

</div>

<div class="row">
    <div class="form-group col-sm-12 col-md-6">
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

    <div class="form-group col-sm-12 col-md-6">
        <label for="taxable_unit">
            @lang('labels.products.taxable_unit')
        </label>
        <input
                type="text"
                name="taxable_unit"
                class="form-control {{ has_error_class('taxable_unit') }}"
                id="taxable_unit"
                placeholder="@lang('placeholders.products.taxable_unit')"
                value="{{old('taxable_unit') ?? $product->taxable_unit ?? ''}}">
        @errorblock('taxable_unit')
    </div>
</div>

<bundle-product :old='@json(old())' :categories='@json($categories)'></bundle-product>
