@csrf
<div class="row">
    <div class="form-group col-sm-12 col-md-6">
        <label for="userName">
            @lang('labels.companies.name')
        </label>
        <input
                type="text"
                name="name"
                class="form-control {{ has_error_class('name') }}"
                id="userName"
                placeholder="@lang('placeholders.companies.name')"
                value="{{old('name') ?? $company->name ?? ''}}">
        @errorblock('name')
    </div>

    <div class="form-group col-sm-12 col-md-6">
        <label for="userName">
            @lang('labels.companies.corporate_name')
        </label>
        <input
                type="text"
                name="corporate_name"
                class="form-control {{ has_error_class('corporate_name') }}"
                id="corporate_name"
                placeholder="@lang('placeholders.companies.corporate_name')"
                value="{{old('corporate_name') ?? $company->corporate_name ?? ''}}">
        @errorblock('corporate_name')
    </div>
</div>