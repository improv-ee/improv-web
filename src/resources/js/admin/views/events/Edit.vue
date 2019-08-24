<template>
  <div>
    <b-breadcrumb
      v-if="breadcrumbs"
      :items="breadcrumbs" />
    <event-form :event="event" />
  </div>
</template>

<script>
export default {
    data() {
        return {
            event: {},
            breadcrumbs: []
        };
    },
    mounted() {
        axios.get(config.apiUrl + '/events/'+this.$route.params.uid)
            .then(response => {
                this.event = response.data.data;
                this.breadcrumbs = [
                    {
                        text: this.$t('nav.productions'),
                        to: { name: 'productions' }
                    },
                    {
                        text: this.event.production.title,
                        to: { name: 'production.details', params: {uid: this.event.production.uid } }
                    },
                    {
                        text: this.event.uid,
                        to: { name: 'event.details', params: {uid: this.event.uid} }
                    },
                    {
                        text: this.$t('ui.edit')
                    }
                ];
            });
    }
};
</script>
