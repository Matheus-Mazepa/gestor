@section('button-actions')
    <choose-template
            v-if="item.links.choose_template"
            :url-choose-template="item.links.choose_template">
    </choose-template>
@endsection
