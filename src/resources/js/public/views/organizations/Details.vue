<template>
    <div v-if="organization.slug">

        <h1>{{ organization.name }}</h1>
        <img :src="organization.images.header.urls.original" v-if="hasHeaderImage" :alt="organization.image"
             class="img-responsive header-img"/>

        <vue-markdown :source="organization.description"></vue-markdown>

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
                organization: {}
            }
        },
        computed: {
            hasHeaderImage: function () {
                return this.organization.images && this.organization.images.header && this.organization.images.header.urls && this.organization.images.header.urls.original;
            }
        },
        methods: {
            loadOrganization() {
                let self = this;
                axios.get(config.apiUrl + '/organizations/' + this.$route.params.slug)
                    .then(response => {
                        self.organization = response.data.data;
                    });
            }

        },

        mounted() {
            this.loadOrganization();
        },
        metaInfo() {
            return {
                title: this.organization.name,
                meta: [
                    {
                        property: 'og:image',
                        content: this.hasHeaderImage ? this.organization.images.header.urls.original : null
                    },
                    {property: 'og:description', content: this.organization.description},
                    {property: 'og:title', content: this.organization.name + ' - ' + this.$t('app.name')},
                ]
            }
        }
    }
</script>
