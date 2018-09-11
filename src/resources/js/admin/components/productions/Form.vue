<template>
    <div class="row">
        <div class="col-8 offset-2">

            <h2></h2>
            <b-form @submit.prevent="onSubmit">

                <b-form-group
                        :label="$t('production.attr.title')"
                        label-for="title"
                        :description="$t('production.attr.title_description')">
                    <b-form-input id="title"
                                  type="text"
                                  v-model="form.title"
                                  required
                                  :placeholder="$t('production.attr.title_placeholder')">
                    </b-form-input>
                </b-form-group>
                <b-form-group
                        :label="$t('production.attr.excerpt')"
                        :description="$t('production.attr.excerpt_description')"
                        label-for="excerpt">
                    <b-form-textarea id="excerpt"
                                     type="text" rows="4"
                                     v-model="form.excerpt"
                                     required
                                     :placeholder="$t('production.attr.excerpt_placeholder')">
                    </b-form-textarea>
                </b-form-group>
                <b-form-group
                        :label="$t('production.attr.description')"
                        :description="$t('production.attr.description_description')"
                        label-for="description">
                    <b-form-textarea id="description"
                                     type="text" rows="10"
                                     v-model="form.description" required
                                     required
                                     :placeholder="$t('production.attr.description_placeholder')">
                    </b-form-textarea>
                </b-form-group>

                <b-button type="submit" variant="primary" class="btn-block">{{ $t('ui.edit') }}</b-button>
            </b-form>


        </div>
    </div>
</template>

<script>

    export default {
        props: ['production'],
        data() {
            return {
                form: {}
            }
        },

        methods: {
            onSubmit(evt) {
                let self = this;
                axios.put('/api/productions/' + this.$route.params.slug, this.form)
                    .then(function (response) {

                        self.$router.push({
                            name: 'production.details',
                            params: {slug: response.data.data.slug}
                        })
                    });
            }
        },
        watch: {

            // When the component initializes, the production prop is not yet populated,
            // it will be fetched with async request. Wait for it to complete, then set initial form
            // state to those values
            production: function (production) {
                this.form = {
                    title: production.title,
                    description: production.description,
                    excerpt: production.excerpt
                }
            }
        }

    }
</script>
