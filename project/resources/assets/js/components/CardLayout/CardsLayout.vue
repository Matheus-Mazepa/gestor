<template>
    <div class="row">
        <div class="col-4" v-for="layout in layouts">
            <card-layout-item :layout="layout"></card-layout-item>
        </div>
    </div>
</template>

<script>
    export default {
        name: "cards-layout",

        props: {
            layouts: Array
        },
    };
</script>
