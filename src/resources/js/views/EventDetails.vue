<template>
<div class="event-details">
        <div class="row">
            <div class="col-12 col-md-8">

                <img class="img-fluid event-image"
                     :src="event.production.header_img"
                     :alt="event.production.slug" />
            </div>
            <div class="col-12 col-md-4">
                {{ event.start_time }} - {{ event.end_time }}
            </div>
        </div>

    <div class="row">
        <div class="col-8 offset-2">
            {{ event.production.description }}
        </div>
    </div>
</div>
</template>

<script>
    export default {
        data() {
            return {
                event: {}
            }
        },
        async created() {
            await axios.get('/api/events/'+this.$route.params.uid)
                .then(response => {
                    this.event = response.data.data;
                });
        }
    }
</script>
