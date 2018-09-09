<template>
    <div>

        <div class="row mb-2">
            <div class="col-12 col-md-6 col-lg-4"
                 v-for="event in events"
                 :key="event.id">

                <schedule-feed-event
                        :event="event">
                </schedule-feed-event>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                events: {}
            }
        },
        mounted() {
            axios.get('/api/events')
                .then(response => {
                    this.events = response.data.data;
                });
        }
    }
</script>
