<template>
    <div class="col-sm-12">
        <div class="card">
            <div class="col-md-6">
                <a v-if="urlCreate" :href="urlCreate">
                    <button class="btn btn-secondary mb-2">Criar</button>
                </a>
            </div>
            <div class="card-body">
                <calendar
                        :first-day="1"
                        :all-events="events"
                        :canAddEvent="false"
                        :canDeleteEvent="false"
                        :display-week-number="false"
                        @eventAdded="eventAdded"
                        @eventDeleted="eventDeleted"
                ></calendar>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    name: 'my-calendar',

    props: {
      urlCreate: ''
    },
    data() {
      return {
        events: []
      }
    },
    methods: {
      eventAdded(event) {
        this.events.push(event);
      },
      eventDeleted(event) {
        this.events.splice(this.events.indexOf(event), 1);
      },
    },
    mounted() {
      let me = this;
      setTimeout(function () {
        me.events = [ // you can make ajax call here
          {
            id:1,
            title:'Boleto duas rodas - R$ 2.000,00',
            description: 'Valor R$ 2.000,00',
            color: 'card-danger card-inverse',
            date: new Date()
          },
        ];
      }, 1000);
    }
  }
</script>