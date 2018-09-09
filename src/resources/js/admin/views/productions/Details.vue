<template>
<div>
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
        mounted() {
            axios.get('/api/productions/'+this.$route.params.slug)
                .then(response => {
                    this.production = response.data.data;
                });
        }
    }
</script>
