<template>
    <div class="col-12 product-div">
        <div class="row">
            <div class="form-group col-sm-12 col-md-3">
                <label>
                    Categoria
                </label>
                <v-select :options="categories" v-model="category">
                    <span slot="no-options">Nenhuma categoria definida</span>
                </v-select>

            </div>
            <div class="form-group col-sm-12 col-md-4">
                <label>
                    Produto
                </label>
                <v-select :options="products" v-model="product">
                    <span slot="no-options">Nenhum produto disponível</span>
                </v-select>
            </div>
            <div class="form-group col-sm-12 col-md-2">
                <label>
                    Quantidade
                </label>
                <input
                        id="quantity"
                        v-model="quantity"
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
                        v-money="moneyMask"
                        :name="getFieldName('value')"
                        type="text"
                        placeholder="Insira um valor"
                        class="form-control">


            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-12">
                <label>
                    Observação
                </label>
                <textarea
                        id="observation"
                        v-model="observation"
                        :name="getFieldName('observation')"
                        rows="2"
                        placeholder="Insira uma observação"
                        class="form-control"></textarea>
            </div>
        </div>
        <a class="btn btn-primary col-12 mb-3 text-white" @click="addProduct">Adicionar produto <i
                class="fa fa-plus"></i></a>
    </div>
</template>

<script>
  import {VMoney} from "v-money";

  export default {
    name: 'order-product',

    props: {
      categories: Array,
      productToEdit: Object
    },

    directives: {
      money: VMoney,
    },

    data() {
      return {
        quantity: '',
        observation: '',
        value: '',
        category: '',
        products: [],
        product: '',
        moneyMask: {
          decimal: ',',
          thousands: '.',
          prefix: 'R$ ',
          precision: 2,
        }
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

      productToEdit(productToEdit) {
        this.observation = productToEdit.observation;
        this.quantity = +productToEdit.quantity;
        this.value = productToEdit.value;
      },

      product: function (product) {
        if (product) {
          this.value = product.price_nfe;
        }
      }
    },

    methods: {
      addProduct() {
        const vm = this;
        if (this.product && this.quantity && this.value) {
        this.$emit('add-product', {
          product_name: vm.product.label,
          product_id: vm.product.id,
          quantity: vm.quantity,
          value: vm.value,
          observation: vm.observation,
        });
        this.category = undefined;
        this.product = undefined;
        this.quantity = 0;
        this.useMask = false;
        this.value = 0;
        this.observation = '';
        }
      },

      getFieldName(name) {
        return `temp-products[${name}]`;
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
