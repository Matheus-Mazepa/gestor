<template>
    <div>
        <multiselect
            v-model="values"
            :placeholder="placeholder"
            label="label"
            track-by="id"
            openDirection="bottom"
            :options="options"
            :multiple="true"
            :limit="limit"
            :taggable="taggable"
            @tag="addItem">
        </multiselect>

        <template v-if="values.length">
            <div v-for="(value) in values" :key="value.id">
                <input v-if="taggable" type="hidden" :name="`${name}[]`" :value="value.label">
                <input v-else type="hidden" :name="`${name}[]`" :value="value.id">
            </div>
        </template>
        <input v-else type="hidden" :name="`${name}`" value="">
    </div>
</template>

<script>
  import Multiselect from 'vue-multiselect';

  export default {
    name: "custom-select",

    components: {
      Multiselect
    },

    props: {
      id: String,
      name: String,

      data: {
        type: Array,
        required: true,
      },

      selected: {
        type: Array,
        required: false
      },

      placeholder: {
        type: String,
        required: false,
        default() {
          return 'Pesquise e selecione itens';
        }
      },

      taggable: {
        type: Boolean,
        required: false,
        default() {
          return false;
        }
      },

      limit: {
        type: Number,
        required: false,
        default: 3
      },
    },

    watch: {
      data: function (payload) {
        this.options = payload;
      }
    },

    mounted() {
      this.setSelectedValues(this.selected);
    },

    data() {
      return {
        values: [],
        options: this.data,

      }
    },

    methods: {
      addItem(newTag) {
        const tag = {
          label: newTag,
          id: newTag
        };
        this.options.push(tag);
        this.values.push(tag)
      },

      setSelectedValues(values) {
        let vm = this;
        if (values) {
          this.options.forEach(function (option) {
            values.forEach(function (value) {
              if (option.id.toString() === String(value)) {
                vm.values.push(option);
              }
            })
          });
        }
      }
    }
  };
</script>

<style lang="scss">
    @import '~vue-multiselect/dist/vue-multiselect.min.css';

    .multiselect__option--selected {
        background-color: #8e2de2cc !important;
        color: white !important;
    }

    .multiselect__option--highlight {
        background-color: #8e2de2 !important;
    }

    .multiselect__option:after {
        background-color: #8e2de2 !important;
    }

    .multiselect__tag {
        background-color: #8e2de2 !important;
    }

    .multiselect__tag-icon:after {
        color: white !important;
    }

    .multiselect__tag-icon:hover {
        background-color: #bd70ff !important;
    }

    .is-invalid .multiselect__tags {
        border: 1px solid white;
    }

</style>
