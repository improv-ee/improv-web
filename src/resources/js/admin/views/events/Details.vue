<template>
    <div v-if="event.uid">


        <crud-toolbar resource-name="events"
                      :resource-id="$route.params.uid"
                      :delete-redirect="{name: 'production.details', params: {slug: event.production.slug}}"></crud-toolbar>


        <h1>{{event.title}}</h1>

        <div class="row">
            <div class="col-lg-3 col-event-meta">
                <p><span class="meta-label">
                <i class="far fa-calendar"></i> {{ $t('event.attr.start_time')}}</span><br/>
                    <span class="meta-value">{{ startTime }}</span></p>
            </div>
            <div class="col-lg-3 col-event-meta">
                <p><span class="meta-label">
                    <i class="far fa-calendar"></i> {{ $t('event.attr.end_time')}}</span><br/>
                    <span class="meta-value">{{ endTime }}</span></p>
            </div>
            <div class="col-lg-3 col-event-meta">

            </div>
        </div>



        <p>{{event.description}}</p>


    </div>
</template>

<script>
    export default {
        data() {
            return {
                event: {},
            }
        },
        computed: {
            startTime: function () {
                return moment(this.event.times.start).format('Do MMMM HH:mm')
            },
            endTime: function () {
                return moment(this.event.times.end).format('HH:mm')
            }
        },
        mounted() {
            axios.get(config.apiUrl + '/events/' + this.$route.params.uid)
                .then(response => {
                    this.event = response.data.data;
                });
        }
    }
</script>
