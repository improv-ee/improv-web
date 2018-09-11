<template>
<div>

    <b-button-toolbar key-nav>
        <b-button-group class="mx-1">
        <router-link :to="{ name: 'event.edit', params: {uid: event.uid}}"
                 class="btn btn-sm btn-outline-secondary">{{ $t("ui.edit") }}</router-link>
        <b-button size="sm" variant="outline-danger" @click="markAsDeleted">{{ $t("ui.delete") }}</b-button>
        </b-button-group>
    </b-button-toolbar>

    <h1>{{event.title}}</h1>


    <p>{{event.description}}</p>
<p>{{event.times.start}}</p>


</div>
</template>

<script>
    export default {
        data() {
            return {
                event: {},
            }
        },
        methods: {

            markAsDeleted(){
                let self = this;
                axios.delete('/api/events/'+this.$route.params.uid)
                    .then(response => {
                        self.$router.push({
                            name: 'production.details',
                            params: {slug: self.event.production.slug}
                        })
                    });
            }
        },
        mounted() {
            axios.get('/api/events/'+this.$route.params.uid)
                .then(response => {
                    this.event = response.data.data;
                });
        }
    }
</script>
