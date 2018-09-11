<template>
<div>

    <b-button-toolbar key-nav>
        <b-button-group class="mx-1">
        <router-link :to="{ name: 'production.edit', params: {slug: production.slug}}"
                 class="btn btn-sm btn-outline-secondary">{{ $t("ui.edit") }}</router-link>
        <b-button size="sm" variant="outline-danger" @click="markAsDeleted">{{ $t("ui.delete") }}</b-button>
        </b-button-group>
    </b-button-toolbar>

    {{production.title}}

</div>
</template>

<script>
    export default {
        data() {
            return {
                production: {},
            }
        },
        methods: {
            markAsDeleted(){
                let self = this
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
