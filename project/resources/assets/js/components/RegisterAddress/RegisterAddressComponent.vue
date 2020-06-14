<template>
    <div ref="addressComponent">
        <div class="form-group" :class="{ 'has-danger': hasErrors('cep') }">
            <label class="form-control-label">
                CEP <span v-if="required" class="text-danger">*</span>
            </label>

            <input
                    ref="zipCode"
                    type="text"
                    :name="getFieldName('cep')"
                    v-mask="'#####-###'"
                    v-model="address.zip_code"
                    :class="{ 'is-invalid': hasErrors('cep') }"
                    class="form-control"
            />
            <div v-if="hasErrors('cep')" class="text-danger">
                <strong>{{ this.getErrorMessage("cep") }}</strong>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-8">
                <div
                        class="form-group"
                        :class="{ 'has-danger': hasErrors('street_avenue') }"
                >
                    <label class="form-control-label">
                        Rua/Avenida <span v-if="required" class="text-danger">*</span>
                    </label>

                    <input
                            type="text"
                            :name="getFieldName('street_avenue')"
                            class="form-control"
                            :class="{ 'is-invalid': hasErrors('street_avenue') }"
                            v-model="address.street_avenue"
                    />

                    <div v-if="hasErrors('street_avenue')" class="text-danger">
                        <strong>{{ this.getErrorMessage("street_avenue") }}</strong>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="form-group" :class="{ 'has-danger': hasErrors('number') }">
                    <label class="form-control-label">
                        Número <span v-if="required" class="text-danger">*</span>
                    </label>

                    <input
                            type="text"
                            ref="addressNumber"
                            :name="getFieldName('number')"
                            class="form-control"
                            :class="{ 'is-invalid': hasErrors('number') }"
                            v-model="address.number"
                    />

                    <div v-if="hasErrors('number')" class="text-danger">
                        <strong>{{ this.getErrorMessage("number") }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div
                        class="form-group"
                        :class="{ 'has-danger': hasErrors('district') }"
                >
                    <label class="form-control-label">
                        Bairro <span v-if="required" class="text-danger">*</span>
                    </label>

                    <input
                            type="text"
                            :name="getFieldName('district')"
                            class="form-control"
                            :class="{ 'is-invalid': hasErrors('district') }"
                            v-model="address.district"
                    />

                    <div v-if="hasErrors('district')" class="text-danger">
                        <strong>{{ this.getErrorMessage("district") }}</strong>
                    </div>
                </div>
            </div>
            <div class="col">
                <div
                        class="form-group"
                        :class="{ 'has-danger': hasErrors('complement') }"
                >
                    <label class="form-control-label">
                        Complemento
                    </label>

                    <input
                            type="text"
                            :name="getFieldName('complement')"
                            class="form-control"
                            :class="{ 'is-invalid': hasErrors('complement') }"
                            v-model="address.complement"
                    />

                    <div v-if="hasErrors('complement')" class="text-danger">
                        <strong>{{ this.getErrorMessage("complement") }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group" :class="{ 'has-danger': hasErrors('state') }">
                    <label class="form-control-label">
                        Estado <span v-if="required" class="text-danger">*</span>
                    </label>

                    <select
                            :name="getFieldName('state')"
                            :class="{ 'is-invalid': hasErrors('state') }"
                            class="form-control"
                            v-model="stateSelected"
                    >
                        <option v-for="state in states" :value="state.value">
                            {{ state.text }}
                        </option>
                    </select>

                    <div v-if="hasErrors('state')" class="text-danger">
                        <strong>{{ this.getErrorMessage("state") }}</strong>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-group" :class="{ 'has-danger': hasErrors('city_id') }">
                    <label class="form-control-label">
                        Cidade <span v-if="required" class="text-danger">*</span>
                    </label>

                    <select
                            :name="getFieldName('city_id')"
                            :class="{ 'is-invalid': hasErrors('city_id') }"
                            class="form-control"
                            v-model="citySelected"
                    >
                        <option v-for="city in cities" :value="city.value">
                            {{ city.text }}
                        </option>
                    </select>

                    <div v-if="hasErrors('city_id')" class="text-danger">
                        <strong>{{ this.getErrorMessage("city_id") }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  import AddressService from "../../services/AddressServices";

  export default {
    name: "register-address-component",

    props: {
      old: {
        required: true
      },

      errorsBag: {
        required: true
      },

      required: {
        default: true
      },
    },

    watch: {
      old: function (old) {
        this.address.zip_code = this.getOld('cep');
        this.address.type = this.getOld("type");
        this.address.street_avenue = this.getOld("street_avenue");
        this.address.district = this.getOld("district");
        this.address.city_id = this.getOld("city_id");
        this.address.number = this.getOld("number");
        this.address.complement = this.getOld("complement");
        this.address.state = this.getOld("state");
      },

      address: {
        handler: _.debounce(function (address) {
          this.submitFormFullFilled();
        }, 500),
        deep: true
      },

      stateSelected: function () {
        this.getCities()
          .then(success => {
            this.cities = success.data.map(element => {
              return {
                text: element.name,
                value: element.id
              };
            });
          })
          .then(() => {
            if (this.address.city_id) {
              const city = this.cities.find(
                city =>
                  city.text === this.address.city_id ||
                  city.value === parseInt(this.address.city_id)
              );
              this.citySelected = !!city ? city.value : null;
            }
          });
      },

      "address.zip_code"() {
        this.getCEP();
      }
    },

    data() {
      return {
        states: [],
        stateSelected: null,
        citySelected: null,
        cities: [],
        address: {
          zip_code: '',
          type: this.getOld("type"),
          street_avenue: this.getOld("street_avenue"),
          district: this.getOld("district"),
          city_id: this.getOld("city_id"),
          number: this.getOld("number"),
          complement: this.getOld("complement"),
          state: this.getOld("state")
        }
      };
    },

    created() {
      this.getStates()
        .then(success => {
          this.states = success.data.map(element => {
            return {
              text: element.name,
              value: element.abbr
            };
          });
        })
        .then(() => {
          if (this.address.state) {
            this.stateSelected = this.address.state;
          }
        });
    },

    mounted() {
      this.submitFormFullFilled();

      $(this.$refs.addressComponent)
        .find("input")
        .first()
        .focus(function () {
          $(this)
            .closest(".form-group")
            .removeClass("has-danger");
        });
      this.address.zip_code = this.getOld('cep');
    },

    methods: {
      getOld(name) {
        if (!this.old) {
          return '';
        }
        return this.old.address
          ? this.old.address[name] : this.old[name];
      },

      getFieldPath(name) {
        return `address.${name}`;
      },

      getFieldName(name) {
        return `address[${name}]`;
      },

      getErrorMessage(name) {
        name = this.getFieldPath(name);

        return this.errorsBag[name].toString();
      },

      hasErrors(name) {
        name = this.getFieldPath(name);

        return !!this.errorsBag[name];
      },

      getCEP() {
        if (this.address.zip_code && this.address.zip_code.length == 9) {
          this.getAddress(this.address.zip_code.replace("-", ""))
            .then(success => {
              let data = success.data;
              if (!data.error) {
                this.setAddress(data);
                this.$refs.addressNumber.focus();
              }
            })
            .catch(error => {
              this.$snotify.error(`Ocorreu um erro ao buscar CEP: ${error}`);
            });
        }
      },

      setAddress(data) {
        this.address.street_avenue = data.logradouro;
        this.address.district = data.bairro;
        this.address.city_id = data.localidade;
        this.address.state = data.uf;

        this.stateSelected = data.uf;
      },

      getAddress(cep) {
        return AddressService.getAddressForCep(cep);
      },

      getStates() {
        return AddressService.getStates();
      },

      getCities() {
        return AddressService.getCitiesFor(this.stateSelected);
      },

      submitFormFullFilled() {
        if (
          this.address.street_avenue &&
          this.address.street_avenue.length &&
          this.address.district &&
          this.address.district.length &&
          this.address.city_id &&
          this.address.city_id.length &&
          this.address.zip_code &&
          this.address.zip_code.length &&
          this.address.number &&
          this.address.number.length &&
          this.address.state &&
          this.address.state.length
        ) {
          this.$emit("formFullFilled", {
            filled: true,
            data: this.address
          });
          return;
        }

        this.$emit("formFullFilled", {
          filled: false,
          data: {}
        });
      }
    }
  };
</script>
