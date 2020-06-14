<template>
    <div class="col-12 product-div">
        <div class="row">
            <div class="form-group col-sm-12 col-md-3">
                <label>
                    Categoria
                </label>
                <custom-select
                        name="category"
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
                        :name="getFieldName('product_id')"
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
                        :name="getFieldName('quantity')"
                        type="number"
                        placeholder="Insira a quantidade"
                        class="form-control">
            </div>
            <div class="form-group col-sm-12 col-md-3">
                <label>
                    Valor unitário
                </label>
                <input
                        id="value"
                        inputmode="numeric"
                        v-model="value"
                        :name="getFieldName('value')"
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
                        id="observation"
                        :name="getFieldName('observation')"
                        rows="2"
                        placeholder="Insira uma observação"
                        class="form-control"></textarea>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    name: 'order-product',

    props: {
      categories: Array,
      index: Number
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
        console.log(product);
        this.value = product.price_nfe;
        $('.mask-money').mask("#.##0,00", {reverse: true});
      }
    },

    methods: {
      getFieldName(name) {
        return `products[${this.index}][${name}]`;
      },
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
