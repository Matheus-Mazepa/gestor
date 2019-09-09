<template>
  <div class="page-breadcrumb">
    <div class="row align-items-center">
      <div class="col-5">
        <h4 class="page-title">{{ header }}</h4>
        <div class="d-flex align-items-center">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <slot></slot>
            </ol>
          </nav>
        </div>
      </div>
      <div class="col-7">
        <div class="text-right upgrade-btn">
          <a href="#" class="btn btn-danger text-white" target="_blank">
            Upgrade to Pro
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
    icon: {
      type: String,
      required: false
    }
  }
};
</script>
