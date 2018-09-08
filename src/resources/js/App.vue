<template>
<div>
    <schedule-feed-event
            :production="production">
    </schedule-feed-event>
    <event-schedule></event-schedule>
</div>
</template>

<script>
    export default {
        data() {
            return {
                production: {}
            }
        },
        mounted() {
            axios.get('/api/productions?page=58')
                .then(response => {
                    this.production = response.data.data[0];
                });
        }
    }
</script>