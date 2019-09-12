<th sortable @click="orderBy('url_preview', $event)">
    @lang('labels.layouts.preview')
</th>
<th sortable @click="orderBy('title', $event)">
    @lang('labels.layouts.title')
</th>
<th sortable @click="orderBy('description', $event)">
    @lang('labels.layouts.description')
</th>
<th sortable @click="orderBy('created_at', $event)">
    @lang('labels.layouts.created_at')
</th>
<th></th>
