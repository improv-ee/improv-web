<template>
    <production-form :production="production" v-if="production" mode="edit"></production-form>
</template>

<script>
    export default {
        data() {
            return {
                production: {},
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
