<template>
    <div>
        <div class="row">
            <div class="col-6" v-for="event in featuredEvents"                 :key="event.uid">
                <schedule-feed-event :event="event"></schedule-feed-event>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12 col-md-6 col-lg-4"
                 v-for="event in events"
                 :key="event.uid">

                <schedule-feed-event :event="event"></schedule-feed-event>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                events: [],
                featuredEvents: []
            }
        },
        mounted() {
            axios.get('/api/events/schedule')
                .then(response => {
                    this.events = response.data.data;
                    this.featuredEvents = this.events.splice(0,2);

                });
        }
    }
</script>
