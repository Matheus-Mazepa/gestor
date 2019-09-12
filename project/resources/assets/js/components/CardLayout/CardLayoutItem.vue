<template>
    <div class="card">
        <h5 class="card-header text-uppercase text-center">
            Title
        </h5>
        <div class="card-body">
            <img :src="layout">
        </div>
    </div>
</template>

<script>
    export default {
        name: "card-layout-item",

        props: {
            layout: String
        },
    };
</script>


<style scoped>
    .card {
        box-shadow: 0 10px 10px -5px;
    }

    .card-body img {
        width: 300px;
        height: 300px;
    }
</style>
