<template>
    <div class="custom-file">
        <input
            type="file"
            :name="name"
            ref="myFiles"
            :class="{'is-invalid' : hasError(name)}"
            @change="previewFiles"
            class="custom-file-input"
            :id="name">
        <label class="custom-file-label" :class="getClassSelected()" :for="name" data-browse="Buscar">
            {{ getNameFile() }}
        </label>
        <small v-if="hasError(name)" class="text-danger">
            {{ getError(name) }}
        </small>
    </div>
</template>

<script>
    export default {
        name: "input-file",

        props: {
            name: {type: String,
                required: true
            },
            placeholder: {
                type: String,
                required: false
            },
            errors: {
                required: true
            }
        },

        data() {
            return {
                files: []
            }
        },

        methods: {
            previewFiles() {
                this.files = this.$refs.myFiles.files;
            },

            getNameFile() {
                return (this.files.length > 0) ? this.files[0].name : this.placeholder;
            },

            getClassSelected() {
                return (this.files.length > 0) ? 'is-valid border-success' : '';
            },

            getError(key) {
                return this.errors[key][0];
            },

            hasError(key) {
                return !!this.errors[key];
            },
        }
    };
</script>

<style scoped>

</style>
