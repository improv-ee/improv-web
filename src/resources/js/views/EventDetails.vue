<template>

        <div class="row">
            <div class="col-12 col-md-6 col-lg-4">

                <img class="card-img-top flex-auto d-none d-lg-block"
                     :src="event.production.header_img"
                     :alt="event.production.slug" />

                {{ event.production.description }}

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
