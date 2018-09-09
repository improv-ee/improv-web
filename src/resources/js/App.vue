<template>
<div>
    <schedule-feed-event
            :event="event">
    </schedule-feed-event>
    <event-schedule></event-schedule>
</div>
</template>

<script>
    export default {
        data() {
            return {
                event: {}
            }
        },
        mounted() {
            axios.get('/api/events')
                .then(response => {
                    this.event = response.data.data[0];
                });
        }
    }
</script>