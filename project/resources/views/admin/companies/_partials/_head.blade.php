<th sortable @click="orderBy('name', $event)">
    @lang('labels.common.name')
</th>
<th sortable @click="orderBy('corporate_name', $event)">
    @lang('labels.companies.corporate_name')
</th>
<th sortable @click="orderBy('created_at', $event)">
    @lang('labels.common.created_at')
</th>
<th sortable @click="orderBy('updated_at', $event)">
    @lang('labels.common.updated_at')
</th>
<th></th>
