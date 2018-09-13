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

                <b-form-group :label="$t('production.img.header')"
                label-for="header-img"
                              :description="$t('production.img.header_description')">
                    <b-form-file @change="uploadHeaderImg"
                                 accept="image/jpeg, image/png, image/webp"
                                 :placeholder="$t('production.img.select_file')"></b-form-file>
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
                                     v-model="form.description"
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
                form: {},
            }
        },

        methods: {
            uploadHeaderImg(e){
                let self = this;
                let formData = new FormData();
                formData.append('image', e.srcElement.files[0]);
                axios.post('/api/images',formData, {
                    onUploadProgress: this.uploadProgress,
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },
                    errorHandle: false})
                    .then(function (response) {
                        self.form.header_img = response.data.uid

                }).catch((error) => {

                    for (var i = 0; i < error.response.data.errors.image.length; i++) {
                        self.$notify({
                            type: 'error',
                            group: 'app',
                            title: self.$t('ui.validation_error'),
                            text: error.response.data.errors.image[i]
                        });
                    }


                })
            },
            uploadProgress(progressEvent){
                let percentCompleted = Math.round( (progressEvent.loaded * 100) / progressEvent.total );
                console.log(percentCompleted);
            },
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
                    excerpt: production.excerpt,
                    header_img: production.images.header.uid
                }
            }
        }

    }
</script>
