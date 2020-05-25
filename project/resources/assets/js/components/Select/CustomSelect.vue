<template>
    <div>
        <input type="hidden" :name="name" :value="(!!data) ? data.id : ''">
        <v-select :placeholder="placeholder" :options="options" v-model="data">
            <span slot="no-options">{{noOptions}}</span>
        </v-select>
    </div>
</template>

<script>
  export default {
    name: "custom-select",

    props: {
      name: {
        type: String,
        required: true
      },

      noOptions: {
        type: String,
        required: false,
        default: 'Nenhuma opção disponível.'
      },

      options: {
        type: Array,
        required: true
      },

      placeholder: {
        type: String,
        required: false
      },

      old: {
        required: false
      },

      selected: {
        type: Number,
        required: false
      },
    },

    data() {
      return {
        data: []
      }
    },

    watch: {
      selected: function (selected) {
        if (!!selected) {
          this.getSelected(selected);
        } else {
          this.data = [];
        }
      }
    },

    mounted() {
      if (!!this.selected) {
        this.getSelected(this.selected);
      }

      if (!!this.old && this.old.permission_id) {
        this.getSelected(this.old.permission_id);
      }
    },

    methods: {
      getSelected(selected) {
        let vm = this;
        this.options.forEach(function (option) {
          if (selected == option.id) {
            vm.data = option;
          }
        });
      }
    }
  };
</script>
