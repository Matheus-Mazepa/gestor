<template>
    <div class="col-12 mt-3">
        <div class="product-div row">
            <div class="form-group col-sm-12 col-md-6">
                <label>
                    Categoria
                </label>
                <v-select :options="categories" v-model="category">
                    <span slot="no-options">Nenhuma categoria definida</span>
                </v-select>

            </div>
            <div class="form-group col-sm-12 col-md-6">
                <label>
                    Produto
                </label>
                <v-select :options="products" v-model="product">
                    <span slot="no-options">Nenhum produto disponível</span>
                </v-select>
            </div>
            <a class="btn btn-primary col-12 mb-3 text-white" @click="addProduct">Adicionar produto <i
                    class="fa fa-plus"></i></a>
        </div>
        <div ref="container" class="table-responsive" v-if="productsSelected.length > 0">
            <h3>Produtos</h3>
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Produto</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(product, index) in productsSelected">
                    <input type="hidden" name="products[]" :value="product.id">
                    <td>{{product.label}}</td>
                    <td><a class="btn btn-danger text-white" @click="removeProduct(index)">Remover</a></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
  export default {
    name: 'products',

    props: {
      categories: Array,
    },

    data() {
      return {
        category: '',
        products: [],
        productsSelected: [],
        product: '',
      }
    },

    watch: {
      category: function (category) {
        if (category) {
          axios.get('/ajax/client/categories/' + category.id + '/products').then((response) => {
            this.products = response.data;
          });
        }
      },
    },

    methods: {
      addProduct() {
        this.productsSelected.push(this.product);
        this.product = undefined;
        this.category = '';
      },

      removeProduct(productIndex) {
        this.productsSelected.splice(productIndex, 1);
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
