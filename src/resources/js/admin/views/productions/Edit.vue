<template>
  <production-form
    v-if="production"
    :production="production"
    mode="edit" />
</template>

<script>
export default {
    data() {
        return {
            production: {},
        };
    },
    mounted() {
        let self = this;
        axios.get(config.apiUrl + '/productions/' + this.$route.params.slug)
            .then(response => {
                self.production = response.data.data;
            });
    }
};
</script>
