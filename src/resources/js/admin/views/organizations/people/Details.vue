<template>
   <div>
      <table class="table table-striped table-bordered">

         <tbody><tr>
            <th>{{ $t('user.username') }}</th>
            <td>{{ membership.user.username }}</td>
         </tr>
         <tr>
            <td colspan="2">
               <b-button @click="removeMember" variant="danger">{{ $t('organization.remove_member') }}</b-button>
            </td>
         </tr>
         </tbody>
      </table>
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
                axios.post(`/api/organizations/${this.$route.params.slug}/membership/${this.$route.params.username}`,)
                    .then(function () {
                        self.$router.push({
                            name: 'organization.edit',
                            params: { slug: this.$route.params.slug }
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

