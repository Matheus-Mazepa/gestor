@csrf
<div class="row">
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
                    placeholder="@lang('placeholders.products.title') para esta cobrança"
                    value="{{old('title') ?? $product->title ?? ''}}">
            @errorblock('title')
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label for="title">
                Vencimento da cobrança
            </label>
            <input
                    type="text"
                    name="title"
                    class="form-control {{ has_error_class('title') }}"
                    id="title"
                    placeholder="Selecione o vencimento da cobrança"
                    value="{{old('title') ?? $product->title ?? ''}}">
            @errorblock('title')
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label for="title">
                Valor
            </label>
            <input
                    type="text"
                    name="title"
                    class="form-control {{ has_error_class('title') }}"
                    id="title"
                    placeholder="Insira o valor da cobrança"
                    value="{{old('title') ?? $product->title ?? ''}}">
            @errorblock('title')
        </div>
    </div>

    <div class="form-group col-sm-12 col-md-6">
        <label for="payment_form_id">
            @lang('labels.orders.payment_form') *
        </label>
        <custom-select
                name="payment_form_id"
                class="form-group {{ has_error_class('payment_form_id') }}"
                :old='@json(old())'
                @if (old('payment_form_id'))
                selected="{{old('payment_form_id')}}"
                @endif
                {{--                @if (isset($order))--}}
                {{--                :selected="{{ $order->payment_form_id }}"--}}
                {{--                @endif--}}
                placeholder="@lang('placeholders.orders.payment_form')"
                :options="{{ collect($paymentForms) }}"
        ></custom-select>
        @errorblock('payment_form_id')
    </div>
</div>
