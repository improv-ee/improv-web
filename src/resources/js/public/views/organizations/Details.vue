<template>
    <div v-if="organization.slug">

        <h1>{{ organization.name }}</h1>

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
        methods: {

            loadOrganization() {
                let self = this;
                axios.get('/api/organizations/' + this.$route.params.slug)
                    .then(response => {
                        self.organization = response.data.data;
                    });
            }

        },

        mounted() {
            this.loadOrganization();
        }
    }
</script>
