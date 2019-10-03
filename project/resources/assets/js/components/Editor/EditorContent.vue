<template>
    <div class="mt-3">
        <img v-if="files.length !== 0" :src="image" class="content">

        <div class="text-center p-2" v-if="files.length === 0">
            <label>
                ( Click para inserir uma imagem de fundo )
                <input type="file"  @change="previewFiles" ref="myImage" name="image" size="60">
            </label>
        </div>
    </div>
</template>

<script>
    export default {
        name: "editor-content",

        data() {
            return {
                files: [],
                image: ''
            }
        },

        mounted() {
          this.clearImage();
        },

        methods: {
            previewFiles() {
                this.files = this.$refs.myImage.files;
                this.getImage(this.files[0]);
                this.$root.$emit('has-image', true);
            },

            clearImage() {
                const vm = this;
                this.$root.$on('clear-image', function () {
                    this.$root.$emit('has-image', false);
                    vm.files = [];
                });
            },

            getImage(image) {
                const toBase64 = file => new Promise((resolve, reject) => {
                    const reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = () => resolve(reader.result);
                    reader.onerror = error => reject(error);
                });

                toBase64(image).then(response => {
                    this.image = response;
                });
            }
        }
    };
</script>

<style scoped>
    .content {
        background-size: auto;
    }

    label {
        padding: 15px;
        width: 100%;
        height: 10vh;
        background-color: white;
        font-size: 20px;
        font-weight: bold;
    }

    input[type="file"] {
        display: none;
    }
</style>
