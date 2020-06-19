<template>
    <div>
        <div class="row">
            <div class="col-sm-12">
                <order-product @add-product="addProduct" :product-to-edit="product" :categories="categories"></order-product>
            </div>
        </div>
        <div ref="container" class="table-responsive" v-if="products.length > 0">
            <h3>Produtos</h3>
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Valor unitário</th>
                    <th>Valor total</th>
                    <th>Observação</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(product, index) in products">
                    <td>{{product.product_name}}</td>
                    <td>{{product.quantity}}</td>
                    <td>{{product.value}}</td>
                    <td>{{ getTotalValue(product) }}</td>
                    <td>{{product.observation}}</td>
<!--                    <td><a class="btn btn-warning" @click="editProduct(index)">Editar</a></td>-->
                    <td><a class="btn btn-danger text-white" @click="removeProduct(index)">Remover</a></td>
                </tr>
                </tbody>
            </table>

            <div v-for="(product, index) in products">
                <input type="hidden" :name="getFieldName('product_name', index)" :value="product.product_name">
                <input type="hidden" :name="getFieldName('value', index)" :value="product.value">
                <input type="hidden" :name="getFieldName('quantity', index)" :value="product.quantity">
                <input type="hidden" :name="getFieldName('product_id', index)" :value="product.product_id">
                <input type="hidden" :name="getFieldName('observation', index)" :value="product.observation">
            </div>


            <h3 class="text-right">Total do pedido: {{maskMoney(total)}}</h3>

        </div>
    </div>
</template>

<script>
  import OrderProduct from "./OrderProduct";

  export default {
    name: 'create-order',

    components: {
      OrderProduct
    },

    props: {
      categories: Array,
      old: undefined
    },

    data() {
      return {
        indexComponents: 0,
        total: 0,
        products: [],
        product: undefined
      }
    },

    mounted() {
      if (this.old && this.old.products) {
        this.products = this.old.products;
        this.products.forEach((product) => {
          let value = product.value;
          value = +value.replace('.', '').replace(',', '.').replace('R$', '');
          value = (value * 100 * product.quantity) / 100;
          this.total += value;
        });
      }
    },

    methods: {
      editProduct(productIndex) {
        this.product = this.products[productIndex]
      },

      removeProduct(productIndex) {
        const product = this.products[productIndex];
        let value = product.value;
        value = +value.replace('.', '').replace(',', '.').replace('R$', '');
        value = (value * 100 * product.quantity) / 100;
        this.total -= value;

        this.products.splice(productIndex, 1);
      },

      addProduct(payload) {
        let value = payload.value;
        value = +value.replace('.', '').replace(',', '.').replace('R$', '');
        value = (value * 100 * payload.quantity) / 100;
        this.total += value;

        this.products.push(payload);
      },

      getFieldName(name, index) {
        return `products[${index}][${name}]`;
      },

      maskMoney(value) {
        return value.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
      },

      getTotalValue(product) {
        let value = product.value;
        const quantity = product.quantity;
        value = +value.replace('.', '').replace(',', '.').replace('R$', '');
        value = (value * 100 * quantity) / 100;
        return this.maskMoney(value);
      }
    }
  }
</script>
<style scoped>
    .btn-primary {
        color: white !important;
    }
</style>
