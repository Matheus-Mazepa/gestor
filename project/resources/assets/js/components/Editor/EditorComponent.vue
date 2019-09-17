<template>
    <div class="text-center">
        <div class="row p-2">
            <div class="col-md-4">
                <span>Guias:</span>
                <button
                        name="show-grid"
                        type="button"
                        class="btn btn-link btn-xs"
                        data-toggle="tooltip"
                        data-placement="top"
                        title="Mostrar/Ocultar Linhas em Grade">
                    <i class="fa fa-th"></i>
                </button>

                <button
                        name="show-grid-plus"
                        type="button"
                        class="btn btn-link btn-xs"
                        data-toggle="tooltip"
                        data-placement="top"
                        title="Mostrar/Ocultar Linhas em Cruz">
                    <i class="fa fa-plus"></i>
                </button>
            </div>

            <div class="col-md-4">
                <span>Formas:</span>

                <button
                        name="add-text"
                        type="button"
                        class="btn btn-link btn-xs"
                        data-toggle="tooltip"
                        data-placement="top"
                        title="Texto">
                    <i class="fa fa-font"></i>
                </button>


                <button
                        name="add-form"
                        type="button"
                        class="btn btn-link btn-xs"
                        data-toggle="tooltip"
                        data-placement="top"
                        title="Linha"
                        value="line">
                    <i class="fa fa-minus"></i>
                </button>

                <button
                        name="add-form"
                        type="button"
                        class="btn btn-link btn-xs"
                        data-toggle="tooltip"
                        data-placement="top"
                        title="Quadrado"
                        value="square">
                    <i class="fa fa-window-maximize"></i>
                </button>

                <button
                        name="add-form"
                        type="button"
                        class="btn btn-link btn-xs"
                        data-toggle="tooltip"
                        data-placement="top"
                        title="Retângulo"
                        value="rectangle">
                    <i class="fa fa-square-o"></i>
                </button>

                <button
                        name="add-form"
                        type="button"
                        class="btn btn-link btn-xs"
                        data-toggle="tooltip"
                        data-placement="top"
                        title="Círculo"
                        value="circle">
                    <i class="fa fa-circle-o"></i>
                </button>

                <button
                        name="add-form"
                        type="button"
                        class="btn btn-link btn-xs"
                        data-toggle="tooltip"
                        data-placement="top"
                        title="Elipse"
                        value="ellipse">
                    <i class="fa fa-circle-thin"></i>
                </button>
            </div>

            <div class="col-md-4">
                <span>Zoom:</span>
                <button
                        name="zoom-reset"
                        type="button"
                        class="btn btn-link btn-xs"
                        data-toggle="tooltip"
                        data-placement="top"
                        title="Voltar ao Tamanho Original">
                    <i class="fa fa-file-o"></i>
                </button>

                <button
                        name="zoom-out"
                        type="button"
                        class="btn btn-link btn-xs"
                        data-toggle="tooltip"
                        data-placement="top"
                        title="Diminuir Zoom (-10%)">
                    <i class="fa fa-search-minus"></i>
                </button>

                <button
                        name="zoom-in"
                        type="button"
                        class="btn btn-link btn-xs"
                        data-toggle="tooltip"
                        data-placement="top"
                        title="Aumentar Zoom (+10%)">
                    <i class="fa fa-search-plus"></i>
                </button>

                <button v-if="image"
                        name="remove-image"
                        type="button"
                        @click="confirmClear()"
                        class="btn btn-link btn-xs float-right"
                        data-toggle="tooltip"
                        data-placement="top"
                        title="Remover imagem">
                    <i class="fa fa-trash fa-2x"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "editor-component",

        data() {
            return {
                image: false
            }
        },

        mounted() {
            this.hasImage();
        },

        methods: {
            confirmClear() {
                let title = 'Remover imagem';
                let message = 'Tem certeza que deseja remover esta imagem de fundo?';

                this.$snotify.confirm(message, title, {
                    timeout: 5000,
                    showProgressBar: false,
                    closeOnClick: true,
                    pauseOnHover: false,
                    buttons: [
                        {
                            text: 'Sim',
                            action: (toast) => {
                                this.$root.$emit('clear-image');
                                this.$snotify.remove(toast.id);
                            },
                            bold: false
                        },
                        {text: 'Não'},
                    ]
                });
            },

            hasImage() {
                const vm = this;
                this.$root.$on('has-image', function (response) {
                    vm.image =  response;
                });
            }
        }
    };
</script>

<style scoped>
</style>
