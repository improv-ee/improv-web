<template>
    <div>
        <crud-toolbar resource-name="productions"
                      :resource-id="this.$route.params.slug"></crud-toolbar>

        <h1>{{production.title}}</h1>

        <img :src="production.images.header.urls.original" v-if="production.images.header" :alt="production.title"
             class="img-responsive header-img"/>

        <p class="lead">{{production.excerpt}}</p>

        <vue-markdown :source="production.description"></vue-markdown>

        <h2>{{ $t('production.events') }}</h2>

        <div class="table-responsive">
            <table class="table table-clickable">
                <thead class="thead-light">
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
                        <b-button @click="addEvent" variant="primary">{{ $t('ui.add_new') }}</b-button>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>


    </div>
</template>

<script>
    import VueMarkdown from 'vue-markdown'

    export default {
        components: {
            VueMarkdown
        },
        data() {
            return {
                production: null,
            }
        },
        methods: {
            formatTime(date) {
                return moment(date).format('Do MMMM HH:mm');
            },
            openEvent(uid) {
                this.$router.push({name: 'event.details', params: {uid: uid}})
            },
            addEvent() {
                let self = this;
                axios.post(config.apiUrl + '/events', {
                    'production': {'slug': this.$route.params.slug},
                    'times': {
                        'start': moment().add(24, 'h').format(),
                        'end': moment().add(25, 'h').format()
                    }
                })
                    .then(response => {
                        self.$router.push({
                            name: 'event.edit',
                            params: {uid: response.data.data.uid}
                        })
                    });
            }
        },
        mounted() {
            let self = this;
            axios.get(config.apiUrl + '/productions/' + this.$route.params.slug)
                .then(response => {
                    self.production = response.data.data;
                });
        }
    }
</script>
