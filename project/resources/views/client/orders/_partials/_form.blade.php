@csrf
<div class="row">
    <div class="form-group col-sm-12 col-md-6">
        <label for="client_id">
            @lang('labels.orders.client') *
        </label>
        <custom-select
                name="client_id"
                class="form-group {{ has_error_class('client_id') }}"
                :old='@json(old())'
                @if (isset($order))
                :selected="{{ $order->client_id }}"
                @endif
                placeholder="@lang('placeholders.orders.client')"
                :options="{{ collect($clients) }}"
        ></custom-select>
        @errorblock('client_id')
    </div>

    <div class="form-group col-sm-12 col-md-6">
        <label for="payment_form_id">
            @lang('labels.orders.payment_form') *
        </label>
        <custom-select
                name="payment_form_id"
                class="form-group {{ has_error_class('payment_form_id') }}"
                :old='@json(old())'
                @if (isset($order))
                :selected="{{ $order->payment_form_id }}"
                @endif
                placeholder="@lang('placeholders.orders.payment_form')"
                :options="{{ collect($paymentForms) }}"
        ></custom-select>
        @errorblock('payment_form_id')
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-12">
        <label for="payment_form_id">
            @lang('labels.common.observation')
        </label>
        <textarea
                id="description"
                name="description"
                placeholder="@lang('placeholders.common.observation')"
                class="form-control {{ has_error_class('observation') }}"
                rows="5">{{old('observation') ?? $order->observation ?? ''}}</textarea>
        @errorblock('observation')
    </div>
</div>
<create-order :categories='@json($categories)'></create-order>
