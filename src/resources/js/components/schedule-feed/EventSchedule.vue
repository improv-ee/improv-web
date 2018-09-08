<template>
    <div>
        <div class="row">
            <div class="col-md-12"><h3>Kolmapäev, 12 Oktoober</h3></div>
        </div>

        <div class="row mb-2">
            <div class="col-12 col-md-6 col-lg-4"
                 v-for="production in productions"
                 :key="production.id">

                <schedule-feed-event
                        :production="production">
                </schedule-feed-event>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                productions: {}
            }
        },
        mounted() {
            axios.get('/api/productions?page=50')
                .then(response => {
                    this.productions = response.data.data;
                });
        }
    }
</script>
