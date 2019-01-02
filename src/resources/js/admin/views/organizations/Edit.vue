<template>
    <div class="row" v-if="form.name">
        <div class="col-10 offset-1">

            <b-form @submit.prevent="onSubmit">

                <b-form-group
                        :label="$t('organization.attr.name')"
                        label-for="org-name">
                    <b-form-input id="org-name"
                                  type="text"
                                  v-model="form.name"
                                  required>
                    </b-form-input>
                </b-form-group>

                <b-form-group
                        label=""
                        label-for="org-ispublic">

                    <b-form-checkbox id="org-ispublic"
                                     v-model="form.is_public">
                        {{ $t('organization.attr.is_public') }}
                    </b-form-checkbox>

                </b-form-group>

                <b-form-group
                        :label="$t('organization.attr.description')"
                        :description="$t('ui.markdown_supported')"
                        label-for="org-description">
                    <b-form-textarea id="org-description"
                                  type="text"
                                  rows="4"
                                  max-rows="20"
                                  v-model="form.description">
                    </b-form-textarea>
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

                axios.put(config.apiUrl + '/organizations/' + this.$route.params.slug, this.form)
                    .then(function (response) {

                        self.$router.push({
                            name: 'organization.details',
                            params: {slug: response.data.data.slug}
                        })
                    });
            }
        },
        mounted() {
            axios.get(config.apiUrl + '/organizations/' + this.$route.params.slug)
                .then(response => {
                    this.organization = response.data.data;
                    this.form = {
                        name: this.organization.name,
                        description: this.organization.description,
                        is_public: this.organization.is_public
                    }
                });
        },

    }
</script>
