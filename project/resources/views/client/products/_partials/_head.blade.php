<th sortable @click="orderBy('code', $event)">
    @lang('labels.products.code')
</th>
<th sortable @click="orderBy('title', $event)">
    @lang('labels.common.title')
</th>
<th sortable @click="orderBy('description', $event)">
    @lang('labels.products.description')
</th>
<th sortable @click="orderBy('category.name', $event)">
    @lang('labels.products.category')
</th>
<th sortable @click="orderBy('created_at', $event)">
    @lang('labels.common.created_at')
</th>
<th sortable @click="orderBy('updated_at', $event)">
    @lang('labels.common.updated_at')
</th>
<th></th>
