@csrf
<div class="row">
    <div class="form-group col-sm-12 col-md-6">
        <label for="title">
            @lang('labels.common.name')
        </label>
        <input
                type="text"
                name="name"
                class="form-control {{ has_error_class('name') }}"
                id="title"
                placeholder="@lang('placeholders.categories.name')"
                value="{{old('name') ?? $category->name ?? ''}}">
        @errorblock('name')
        @errorblock('parent_id')
    </div>
    <div class="form-group col-sm-12 col-md-6">
        <label for="parent_id">
            @lang('labels.categories.category')
        </label>
        <custom-select
                name="parent_id"
                class="form-group {{ has_error_class('parent_id') }}"
                :old='@json(old())'
                @if (isset($category))
                :selected="{{ $category->parent_id }}"
                @endif
                placeholder="@lang('placeholders.categories.parent')"
                :options="{{ collect($categories) }}"
        ></custom-select>
    </div>
</div>

