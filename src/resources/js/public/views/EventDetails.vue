<template>
<div class="event-details">
        <div class="row">
            <div class="col-md-8 offset-md-2 col-lg-8 offset-lg-2">

                <img class="img-fluid event-image"
                     :src="production.images.header.url"
                     :alt="event.production.slug" />
            </div>
        </div>
    <div class="row">
        <div class="offset-lg-1 col-lg-2">
                <p>{{ startTime }} - {{ endTime }}</p>
            </div>
        </div>

    <div class="row">
        <div class="col-md-10 offset-md-1 col-lg-10 offset-lg-1">
            <h1>{{ production.title }}</h1>
            <p>{{ production.description }}</p>
        </div>
    </div>
</div>
</template>

<script>
    export default {
        data() {
            return {
                event: {},
                production: {}
            }
        },
        computed: {
            startTime: function () {
                return moment(this.event.times.start).format('Do MMMM HH:mm')
            },
            endTime: function () {
                return moment(this.event.times.end).format('Do MMMM HH:mm')
            }
        },
        methods: {
            loadProduction: function (slug) {
                axios.get('/api/productions/'+slug)
                    .then(response => {
                        this.production = response.data.data;
                    });
            }
        },
        created() {
            axios.get('/api/events/'+this.$route.params.uid)
                .then(response => {
                    this.event = response.data.data;
                    this.loadProduction(this.event.production.slug)
                });
        }
    }
</script>
