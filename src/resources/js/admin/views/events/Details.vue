<template>
    <div v-if="event.uid">

        <crud-toolbar resource-name="events"
                      :resource-id="$route.params.uid"
                      :delete-redirect="{name: 'production.details', params: {slug: event.production.slug}}"></crud-toolbar>

        <h1>{{event.title}}</h1>


        <p>{{event.description}}</p>
        <p>{{event.times.start}}</p>


    </div>
</template>

<script>
    export default {
        data() {
            return {
                event: {},
            }
        },
        mounted() {
            axios.get('/api/events/' + this.$route.params.uid)
                .then(response => {
                    this.event = response.data.data;
                });
        }
    }
</script>
