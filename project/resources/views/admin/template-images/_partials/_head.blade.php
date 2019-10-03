<th>
    @lang('labels.template_images.preview')
</th>
<th sortable @click="orderBy('title', $event)">
    @lang('labels.template_images.title')
</th>
<th sortable @click="orderBy('created_at', $event)">
    @lang('labels.template_images.created_at')
</th>
<th sortable @click="orderBy('updated_at', $event)">
    @lang('labels.template_images.updated_at')
</th>
<th></th>
