@csrf
<div class="row">
    <div class="form-group col-sm-12 col-md-6">
        <label for="userName">
            @lang('labels.common.name')
        </label>
        <input
                type="name"
                name="name"
                class="form-control {{ has_error_class('name') }}"
                id="userName"
                placeholder="@lang('placeholders.common.name')"
                value="{{old('name') ?? $user->name ?? ''}}">
        @errorblock('name')
    </div>

    <div class="form-group col-sm-12 col-md-6">
        <label for="userEmail">
            @lang('labels.auth.email')
        </label>
        <input
                type="email"
                name="email"
                class="form-control {{ has_error_class('email') }}"
                id="userEmail"
                placeholder="@lang('placeholders.auth.email')"
                value="{{old('email') ?? $user->email ?? ''}}">
        @errorblock('email')
    </div>
</div>

<div class="row">
    <div class="form-group col-sm-12 col-md-6">
        <label for="userPassword">
            @lang('labels.auth.password')
        </label>
        <input
                type="password"
                name="password"
                class="form-control {{ has_error_class('password') }}"
                id="userPassword"
                placeholder="@lang('placeholders.auth.password')">
        @errorblock('password')
    </div>

    <div class="form-group col-sm-12 col-md-6">
        <label for="confirmPassword">
            @lang('labels.auth.password_confirmation')
        </label>
        <input
                type="password"
                name="password_confirmation"
                class="form-control"
                id="confirmPassword"
                placeholder="@lang('placeholders.auth.password_confirmation')">
    </div>

</div>