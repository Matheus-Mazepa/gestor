<template>

    <div class="card-body">
        <calendar
                :all-events="events"
                :canAddEvent="false"
                :canDeleteEvent="false"
                :display-week-number="false"
                :first-day="1"
                @eventAdded="eventAdded"
                @eventDeleted="eventDeleted"
        ></calendar>
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
                        id: 1,
                        title: 'Boleto duas rodas - R$ 2.000,00',
                        description: 'Valor R$ 2.000,00',
                        color: 'card-danger card-inverse',
                        date: new Date()
                    },
                ];
            }, 1000);
        }
    }
</script>