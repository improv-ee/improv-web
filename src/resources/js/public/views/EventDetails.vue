<template>
    <div class="event-details" v-if="production.slug && event.uid">
        <div class="row">
            <div class="col-md-12 col-lg-12">

                <img class="img-fluid header-img"
                     :src="header_img"
                     :alt="event.production.slug"/>
            </div>
        </div>
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
                <p><span class="meta-label">
                    <i class="far fa-address-card"></i> {{ $t('event.attr.organizers')}}</span><br/>
                    <span class="meta-value">
                        <ul class="list-inline">
                            <li v-for="organization in production.organizations">
                                <router-link :to="{name: 'organization.details', params: {slug: organization.slug}}">{{ organization.name }}</router-link>
                            </li>
                        </ul>
                    </span></p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-lg-12">
                <h1>{{ title }}</h1>
                <vue-markdown :source="description"></vue-markdown>
            </div>
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
                event: {},
                production: {}
            }
        },
        computed: {
            title: function(){
                if (this.event.title !== null){
                    return this.event.title;
                }
                return this.production.title;
            },
            description: function(){
                if (this.event.description !== null){
                    return this.event.description;
                }
                return this.production.description;
            },
            header_img() {
                return this.production.images && this.production.images.header && this.production.images.header.urls.original != null ? this.production.images.header.urls.original : '/img/production/default-header.jpg';
            },
            startTime: function () {
                return moment(this.event.times.start).format('Do MMMM HH:mm')
            },
            endTime: function () {
                return moment(this.event.times.end).format('HH:mm')
            }
        },
        methods: {
            loadProduction: function (slug) {
                axios.get(config.apiUrl + '/productions/' + slug)
                    .then(response => {
                        this.production = response.data.data;
                    });
            }
        },
        created() {
            axios.get(config.apiUrl + '/events/' + this.$route.params.uid)
                .then(response => {
                    this.event = response.data.data;
                    this.loadProduction(this.event.production.slug)
                });
        },
        metaInfo () {
            return {
                title: this.title,
                meta: [
                    {property: 'og:image', content: this.header_img},
                    {property: 'og:description', content: this.description},
                    {property: 'og:title', content: this.title + ' - ' + this.$t('app.name')},
                ]
            }
        }
    }
</script>
