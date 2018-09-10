<template>
    <production-form :production="production"></production-form>
</template>

<script>
    export default {
        data() {
            return {
                production: {},
            }
        },
        mounted() {
            if (this.$route.params.slug) {
            axios.get('/api/productions/'+this.$route.params.slug)
                .then(response => {
                    this.production = response.data.data;
                });
        }
        }
    }
</script>
