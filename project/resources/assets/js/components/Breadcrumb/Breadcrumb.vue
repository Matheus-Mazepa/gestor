<template>
  <div class="page-breadcrumb">
    <div class="row align-items-center">
      <div>
        <h4 class="page-title">{{ header }}</h4>
        <div class="align-items-center">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb col-12">
              <slot></slot>
            </ol>
          </nav>
        </div>
      </div>

      <div class="col-sm-3" v-if="urlBack">
        <div class="text-right upgrade-btn">
          <a :href="urlBack" class="btn btn-instagram text-white">
            Voltar
          </a>
        </div>
      </div>

    </div>
  </div>
</template>

<script>
export default {
  name: "Breadcrumb",

  props: {
    header: {
      type: String,
      required: false
    },

    urlBack: {
      type: String,
      required: false
    },
  },
};
</script>

<style scoped>
  .page-breadcrumb {
    padding-left: 30px;
  }
</style>