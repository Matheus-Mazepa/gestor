<template>
    <div class="col-12 product-div">
        <div class="row">
            <div class="form-group col-sm-12 col-md-3">
                <label>
                    Categoria
                </label>
                <custom-select
                        name="products"
                        class="form-group"
                        v-model="category"
                        :options="categories"
                ></custom-select>
            </div>
            <div class="form-group col-sm-12 col-md-4">
                <label>
                    Produto
                </label>
                <custom-select
                        name="products"
                        class="form-group"
                        v-model="product"
                        :options="products"
                ></custom-select>
            </div>
            <div class="form-group col-sm-12 col-md-2">
                <label>
                    Quantidade
                </label>
                <input
                        id="quantity"
                        inputmode="numeric"
                        name="description"
                        type="number"
                        placeholder="Insira uma observação"
                        class="form-control">
            </div>
            <div class="form-group col-sm-12 col-md-3">
                <label>
                    Valor unitário
                </label>
                <input
                        id="value"
                        v-model="value"
                        name="value"
                        type="text"
                        placeholder="Insira um valor"
                        class="form-control mask-money">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-12">
                <label>
                   Observação
                </label>
                <textarea
                        id="description"
                        name="description"
                        rows="2"
                        placeholder="Insira a quantidade"
                        class="form-control"></textarea>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    name: 'order-product',

    props: {
      categories: Array
    },

    data() {
      return {
        value: '',
        category: '',
        products: [],
        product: ''
      }
    },

    watch: {
      category: function (category) {
        axios.get('/ajax/client/categories/' + category.id + '/products').then((response) => {
          this.products = response.data;
        });
      },

      product: function (product) {
        this.value = product.value;
        $('.mask-money').mask("#.##0,00", {reverse: true});
      }
    }
  }
</script>

<style scoped>
    .product-div {
        border: 1px solid #d0d0d0;
        margin-bottom: 10px;
        border-radius: 6px;
        padding: 10px;
    }
</style>
