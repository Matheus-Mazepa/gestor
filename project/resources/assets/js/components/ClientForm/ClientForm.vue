<template>
    <div>
        <div class="row">
            <div class="form-group col-sm-12 col-md-4">
                <label for="name">
                    Nome
                </label>
                <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control">
            </div>
            <div class="form-group col-sm-12 col-md-4">
                <label for="email">
                    Email
                </label>
                <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control">
            </div>
            <div class="form-group col-sm-12 col-md-4">
                <label for="phone">
                    Telefone
                </label>
                <input
                        type="text"
                        id="phone"
                        v-mask="phoneMask"
                        v-model="phone"
                        name="phone"
                        class="form-control">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <label>Tipo de usuário</label>
                <div class="col-sm-12">
                    <div class="custom-control-inline custom-radio col-sm-4">
                        <input v-model="typeClient" type="radio" value="cpf" class="custom-control-input" id="cpf"
                               name="is_legal_person" checked>
                        <label class="custom-control-label" for="cpf">CPF</label>
                    </div>

                    <div class="custom-control-inline custom-radio">
                        <input v-model="typeClient" type="radio" value="cnpj" class="custom-control-input" id="cnpj"
                               name="is_legal_person">
                        <label class="custom-control-label" for="cnpj">CNPJ</label>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-3">
                <label for="phone">
                    {{ typeClient.toLocaleUpperCase() }}
                </label>
                <input
                        type="text"
                        id="cpf_cnpj"
                        v-mask="documentMask"
                        v-model="cpf_cnpj"
                        name="cpf_cnpj"
                        class="form-control">
            </div>
            <div class="col-sm-12 col-md-3">
                <label for="phone">
                    Inscrição estadual
                </label>
                <div class="input-group mb-3">
                    <input
                            :disabled="typeClient === 'cpf' || ieFree"
                            type="text"
                            id="ie_estadual"
                            name="ie_estadual"
                            class="form-control">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary"
                                @click="ieFree = !ieFree"
                                :class="{'active': ieFree}"
                                type="button"
                        >Isento
                        </button>
                    </div>
                </div>

            </div>

            <div class="col-sm-12 col-md-3">
                <label for="phone">
                    Inscrição municipal
                </label>
                <input
                        type="text"
                        id="ie_municipal"
                        name="ie_municipal"
                        class="form-control">
            </div>
        </div>
        <div class="row">
            <register-address-component
                    class="col-12"
                    :old="oldAddress"
                    :errors-bag="errorsBag"
            ></register-address-component>
        </div>
    </div>
</template>

<script>
  export default {
    name: 'client-form',

    props: {
      old: {
        required: true
      },

      errorsBag: {
        required: true
      },

      client: {
        required: false
      }
    },

    data() {
      return {
        phoneMask: "(##) #?####-####",
        documentMask: "##.###.###/####-##",
        phone: '',
        cpf_cnpj: '',
        typeClient: 'cnpj',
        ieFree: false,
        oldAddress: undefined
      };
    },

    mounted() {
      if (this.old.length > 0){
        this.oldAddress = this.old;
      } else {
        if (this.client) {
          this.oldAddress = this.client.address;
        }
      }

    },

    watch: {
      phone: function (phone) {
        if (!phone) {
          this.phoneMask = "(##) #####-####";
          return;
        }

        this.phoneMask = (phone.length >= 15)
          ? "(##) #####-####"
          : "(##) ####-####";
      },

      typeClient: function (typeClient) {
        if (typeClient === 'cpf') {
          this.documentMask = "###.###.###-##";
        } else {
          this.documentMask = "##.###.###/####-##";
        }
      }
    },

  }
</script>
