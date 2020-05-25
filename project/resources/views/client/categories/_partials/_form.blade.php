@csrf
<div class="row">
    <div class="form-group col-sm-12 col-md-6">
        <label for="title">
            @lang('labels.common.name')
        </label>
        <input
                type="text"
                name="title"
                class="form-control {{ has_error_class('title') }}"
                id="title"
                placeholder="@lang('placeholders.categories.name')"
                value="{{old('name') ?? $category->name ?? ''}}">
        @errorblock('name')
    </div>

    <div class="form-group col-sm-12 col-md-6">
        <label for="permissions">
            @lang('labels.categories.category')
        </label>
        <custom-select
                name="category_id"
                class="form-group {{ has_error_class('category_id') }}"
                :old='@json(old())'
                @if (isset($category))
                :selected="{{ $category->category_id }}"
                @endif
                placeholder="@lang('placeholders.categories.parent')"
                :options="{{ collect($categories) }}"
        ></custom-select>
        @errorblock('category_id')
    </div>
</div>
