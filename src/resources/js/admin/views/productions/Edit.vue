<template>
  <div>
    <b-breadcrumb
            v-if="breadcrumbs"
            :items="breadcrumbs" />
    <production-form
            v-if="production"
            :production="production"
            mode="edit" />
  </div>
</template>

<script>
export default {
    data() {
        return {
            production: {},
            breadcrumbs: []
        };
    },
    mounted() {
        let self = this;
        axios.get(config.apiUrl + '/productions/' + this.$route.params.uid)
            .then(response => {
                self.production = response.data.data;

                this.breadcrumbs = [
                    {
                        text: this.$t('nav.productions'),
                        to: { name: 'productions' }
                    },
                    {
                        text: this.production.title,
                        to: { name: 'production.details', params: {uid: this.production.uid } }
                    },
                    {
                        text: this.$t('ui.edit')
                    },
                ];
            });
    }
};
</script>
