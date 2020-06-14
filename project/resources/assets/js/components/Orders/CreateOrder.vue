<template>
    <div>
        <div ref="container"></div>
        <div class="row">
            <div class="col-sm-12">
                <a class="btn btn-primary col-12 mb-3" @click="addProduct">Adicionar produto <i class="fa fa-plus"></i></a>
            </div>
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
        categories: Array
      },

      data() {
        return {
          indexComponents: 0
        }
      },

      methods: {
        addProduct() {
          const vm = this;
          let newFile = Vue.extend(OrderProduct);
          let newInstance = new newFile({
            propsData: {
              categories: vm.categories,
              index: vm.indexComponents
            }
          });

          newInstance.$mount();
          this.$refs.container.appendChild(newInstance.$el);

          this.indexComponents++;
        }
      }
    }
</script>
<style scoped>
    .btn-primary {
        color: white!important;
    }
</style>
