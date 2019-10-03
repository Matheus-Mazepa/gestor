<template>
    <div>
        <a v-if="situation === false"
           href="#"
           @click="chooseTemplate(true)"
           class="btn btn-sm btn-secondary"
           title="Definir template"
           data-toggle="tooltip"
           data-placement="top"
           role="button">
            <i class="fa fa-check-circle"></i>
        </a>

        <a v-if="situation === true"
           href="#"
           @click="chooseTemplate(false)"
           class="btn btn-sm btn-danger"
           title="Remover template"
           data-toggle="tooltip"
           data-placement="top"
           role="button">
            <i class="fa fa-close"></i>
        </a>
    </div>
</template>

<script>
    export default {
        name: "choose-template",

        props: {
            urlChooseTemplate: String
        },

        data() {
            return {
                situation: false
            }
        },

        methods: {
            async chooseTemplate(payload) {
                const response = await axios.post(this.urlChooseTemplate, {
                    situation: payload
                });

                this.situation = response.data.situation;
            }
        }
    };
</script>
