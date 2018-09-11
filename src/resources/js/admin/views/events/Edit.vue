<template>
    <event-form :event="event"></event-form>
</template>

<script>
    export default {
        data() {
            return {
                event: {},
            }
        },
        mounted() {
            axios.get('/api/events/'+this.$route.params.uid)
                .then(response => {
                    this.event = response.data.data;
                });
        }
    }
</script>
