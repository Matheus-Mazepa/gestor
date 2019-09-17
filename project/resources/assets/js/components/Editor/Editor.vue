<template>
    <div>
        <div class="form-group">
            <label for="title">
                Título <span class="text-danger">*</span>
            </label>
            <input
                    class="form-control"
                    id="title"
                    type="text"
                    name="title"
                    placeholder="Insira um título"
                    errors="null"/>
        </div>

        <div class="box-editor mt-5">
            <div class="auxiliary-components">
                <editor-component></editor-component>
                <div class="component-attributes"></div>
                <input type="hidden" name="content"/>
                <div class="poster-block">
                    <div id="poster-editor" class="poster-editor grid-off editor-ready text-center">
                        <editor-content></editor-content>
                    </div>
                </div>
                <editor-footer></editor-footer>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "editor",
    };
</script>

<style scoped>
</style>
