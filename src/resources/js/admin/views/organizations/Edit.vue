<template>
    <div class="row" v-if="form.name">
        <div class="col-10 offset-1">

            <b-form @submit.prevent="onSubmit">

                <b-form-group
                        :label="$t('organization.attr.name')"
                        label-for="name">
                    <b-form-input id="name"
                                  type="text"
                                  v-model="form.name"
                                  required>
                    </b-form-input>
                </b-form-group>


                <b-button type="submit" variant="primary" class="btn-block">{{ $t('ui.edit') }}</b-button>
            </b-form>


        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                organization: {},
                form: {}
            }
        },
        methods: {
            onSubmit() {
                let self = this;

                axios.put('/api/organizations/' + this.$route.params.slug, this.form)
                    .then(function (response) {

                        self.$router.push({
                            name: 'organization.details',
                            params: {slug: response.data.data.slug}
                        })
                    });
            }
        },
        mounted() {
            axios.get('/api/organizations/' + this.$route.params.slug)
                .then(response => {
                    this.organization = response.data.data;
                    this.form = {
                        name: this.organization.name
                    }
                });
        },

    }
</script>
