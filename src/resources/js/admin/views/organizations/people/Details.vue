<template>
   <div>

      <b-card :title="membership.user.name"
              :img-src="membership.user.avatar"
              img-alt="Avatar"
              img-top
              tag="article"
              style="max-width: 20rem;">
         <b-button @click="removeMember" variant="danger">{{ $t('organization.remove_member') }}</b-button>

      </b-card>



   </div>
</template>

<script>


    export default {
        data() {
            return {
                membership: {},
            }
        },
        methods: {
            removeMember() {
                let self = this;
                axios.delete(`/api/organizations/${this.$route.params.slug}/membership/${this.$route.params.username}`,)
                    .then(function () {
                        self.$router.push({
                            name: 'organization.details',
                            params: { slug: self.$route.params.slug }
                        })
                    });

            },
            loadMember() {
                let self = this;
                axios.get(`/api/organizations/${this.$route.params.slug}/membership/${this.$route.params.username}`)
                    .then(response => {
                        self.membership = response.data.data;
                    });
            }

        },

        mounted() {
            this.loadMember();
        }
    }
</script>

