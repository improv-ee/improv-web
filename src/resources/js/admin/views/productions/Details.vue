<template>
<div>

    <b-button-toolbar key-nav>
        <b-button-group class="mx-1">
        <router-link :to="{ name: 'production.edit', params: {slug: production.slug}}"
                 class="btn btn-sm btn-outline-secondary">{{ $t("ui.edit") }}</router-link>
        <b-button size="sm" variant="outline-danger" @click="markAsDeleted">{{ $t("ui.delete") }}</b-button>
        </b-button-group>
    </b-button-toolbar>

    <h1>{{production.title}}</h1>

    <p class="lead">{{production.excerpt}}</p>

    <p>{{production.description}}</p>

    <div class="table-responsive">
    <table class="table table-clickable">
        <thead>
        <tr>
            <th>{{ $t('production.attr.title') }}</th>
            <th>{{ $t('event.attr.start_time') }}</th>
        </tr>
        </thead>
        <tbody>
            <tr @click="openEvent(event.uid)" v-for="event in production.events" v-if="production.events">
                <td>{{ event.title || production.title }}</td>
                <td>{{ formatTime(event.times.start) }}</td>
            </tr>
            <tr v-else>
                <td colspan="2">{{ $t('production.no_events') }}</td>
            </tr>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="2">
                <b-button @click="addEvent">{{ $t('ui.add_new') }}</b-button>
            </td>
        </tr>
        </tfoot>
    </table>
    </div>


</div>
</template>

<script>
    var moment = require('moment');
    export default {
        data() {
            return {
                production: {},
            }
        },
        methods: {
            formatTime(date){
                return moment(date).format('Do MMMM HH:mm');
            },
            openEvent(uid) {
                this.$router.push({ name: 'event.details', params: { uid: uid }})
            },
            addEvent() {
                let self = this;
                axios.post('/api/events', {
                    'production':{'slug':this.$route.params.slug},
                    'times': {
                        'start':moment().add(24, 'h').format(),
                        'end':moment().add(25, 'h').format()
                    }
                })
                    .then(response => {
                        self.$router.push({
                            name: 'event.edit',
                            params: {uid: response.data.data.uid}
                        })
                    });
            },
            markAsDeleted(){
                let self = this;
                axios.delete('/api/productions/'+this.$route.params.slug)
                    .then(response => {
                        self.$router.push({
                            name: 'productions'
                        })
                    });
            }
        },
        mounted() {
            axios.get('/api/productions/'+this.$route.params.slug)
                .then(response => {
                    this.production = response.data.data;
                });
        }
    }
</script>
