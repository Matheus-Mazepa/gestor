<div class="btn-group" v-if="item.links">

    <a v-if="item.links.print" :href="item.links.print"
       target="_blank"
       class="btn btn-sm btn-primary"
       title="@lang('buttons.order.print')"
       data-toggle="tooltip"
       data-placement="top"
       role="button">
        <i class="fa fa-print"></i>
    </a>

    <a v-if="item.links.set_delivered" href="#"
       @click="confirmAndPost(item.links.set_delivered, 'Definir como entregue', 'Tem certeza que deseja definir este pedido como entregue?')"
       target="_blank"
       class="btn btn-sm btn-success text-white"
       title="@lang('buttons.order.set_delivered')"
       data-toggle="tooltip"
       data-placement="top"
       role="button">
        <i class="fa fa-motorcycle"></i>
    </a>

    <a v-if="item.links.show" :href="item.links.show"
       class="btn btn-sm btn-primary"
       title="@lang('buttons.common.show')"
       data-toggle="tooltip"
       data-placement="top"
       role="button">
        <i class="fa fa-eye"></i>
    </a>

    <a v-if="item.links.edit" :href="item.links.edit"
       class="btn btn-sm btn-warning"
       title="@lang('buttons.common.edit')"
       data-toggle="tooltip"
       data-placement="top"
       role="button">
        <i class="fa fa-pencil"></i>
    </a>

    <a v-if="item.links.destroy" @click.prevent="confirmDelete(item.links.destroy)"
       class="btn btn-sm btn-danger"
       title="@lang('buttons.common.destroy')"
       data-toggle="tooltip"
       data-placement="top"
       role="button">
        <i class="fa fa-trash text-white"></i>
    </a>
</div>

