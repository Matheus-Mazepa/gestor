<th>
    @lang('labels.orders.client')
</th>
<th>
    @lang('labels.orders.payment_form')
</th>
<th sortable @click="orderBy('status', $event)">
    @lang('labels.orders.status')
</th>
<th sortable @click="orderBy('created_at', $event)">
    @lang('labels.common.created_at')
</th>
<th sortable @click="orderBy('updated_at', $event)">
    @lang('labels.common.updated_at')
</th>
<th></th>
