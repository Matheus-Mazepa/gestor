<template>
    <div class="mb-2">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" v-model="isBundleProduct" name="bundle-product" id="bundle-product">
            <label class="form-check-label" for="bundle-product">
                É produto agrupador
            </label>
        </div>

        <products v-if="isBundleProduct" :categories="categories"></products>
    </div>
</template>

<script>
  import Products from "./Products";


  export default {
    name: 'bundle-product',

    props: {
      categories: Array,
    },

    components: {
      Products
    },

    data() {
      return {
        isBundleProduct: false,
      }
    }
  }
</script>
<style scoped>
</style>
