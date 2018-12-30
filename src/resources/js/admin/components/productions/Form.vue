<template>
    <div class="row">
        <div class="col-10 offset-1">

            <b-form @submit.prevent="onSubmit" v-if="showForm">

                <b-form-group
                        :label="$t('production.attr.title')"
                        label-for="title"
                        :description="$t('production.attr.title_description')">
                    <b-form-input id="title"
                                  type="text"
                                  v-model="form.title"
                                  required>
                    </b-form-input>
                </b-form-group>

                <b-form-group :label="$t('production.img.header')"
                              label-for="header-img"
                              :description="$t('production.img.header_description')">


                    <div class="overlay-container" v-if="production.hasOwnProperty('images') && production.images.header && form.header_img"
                         @click="removeHeaderImg()">
                        <img class="img-fluid" :src="production.images.header.url"
                             :alt="$t('production.img.header')"/>
                        <div class="img-overlay">
                            <span><i class="far fa-trash-alt fa-10x"></i></span>
                        </div>
                    </div>


                    <b-form-file @change="uploadHeaderImg" v-else
                                 accept="image/jpeg, image/png, image/webp"
                                 :placeholder="$t('production.img.select_file')"></b-form-file>
                </b-form-group>

                <b-form-group
                        :label="$t('production.attr.excerpt')"
                        :description="$t('production.attr.excerpt_description')"
                        label-for="excerpt">
                    <b-form-textarea id="excerpt"
                                     type="text" rows="4"
                                     v-model="form.excerpt">
                    </b-form-textarea>
                </b-form-group>
                <b-form-group
                        :label="$t('production.attr.description')"
                        :description="ui.help.description"
                        label-for="description">
                    <b-form-textarea id="description"
                                     type="text" rows="10"
                                     v-model="form.description"
                                     required>
                    </b-form-textarea>
                </b-form-group>

                <b-button type="submit" variant="primary" class="btn-block">{{ mode === 'edit' ? $t('ui.edit') :
                    $t('ui.create') }}
                </b-button>
            </b-form>

        </div>
    </div>
</template>

<script>

    export default {
        props: {
            "production": Object,
            "mode": {
                "type": String,
                "default": "create"
            }
        },
        data() {
            return {
                form: {},
                ui: {},
                showForm: false
            }
        },

        methods: {
            removeHeaderImg() {
                this.form.header_img = null
            },
            uploadHeaderImg(e) {
                let self = this;
                let formData = new FormData();
                formData.append('image', e.srcElement.files[0]);
                axios.post('/api/images', formData, {
                    onUploadProgress: this.uploadProgress,
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },
                    errorHandle: false
                })
                    .then(function (response) {
                        self.form.header_img = response.data.uid;

                        self.production.images.header.url = response.data.url;

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
            uploadProgress(progressEvent) {
                let percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                console.log(percentCompleted);
            },

            create() {
                let self = this;

                axios.post('/api/productions', this.form)
                    .then(function (response) {

                        self.$router.push({
                            name: 'production.details',
                            params: {slug: response.data.data.slug}
                        })
                    }).catch(function (error) {
                    if (error.response.status >= 500) {
                        self.$notify({
                            type: 'error',
                            group: 'app',
                            title: self.$t('ui.server_error'),
                            text: self.$t('ui.server_error_message')
                        });
                    }
                });
            },
            edit() {
                let self = this;

                axios.put('/api/productions/' + self.production.slug, this.form)
                    .then(function (response) {

                        self.$router.push({
                            name: 'production.details',
                            params: {slug: response.data.data.slug}
                        })
                    }).catch(function (error) {
                    if (error.response.status >= 500) {
                        self.$notify({
                            type: 'error',
                            group: 'app',
                            title: self.$t('ui.server_error'),
                            text: self.$t('ui.server_error_message')
                        });
                    }
                });
            },
            onSubmit() {
                if (this.mode === 'edit') {
                    this.edit();
                } else {
                    this.create();
                }
            }
        },
        mounted() {
            this.ui = {
                help: {
                    description: this.$t('production.attr.description_description') + ' ' + this.$t('ui.markdown_supported')
                }
            }
            if (this.mode === 'create') {
                this.showForm=true
            }
        },
        watch: {

            // When the component initializes, the production prop is not yet populated,
            // it will be fetched with async request. Wait for it to complete, then set initial form
            // state to those values
            production: function (newProductionVal) {
                this.form = {
                    title: newProductionVal.title,
                    description: newProductionVal.description,
                    excerpt: newProductionVal.excerpt,
                    header_img: newProductionVal.images.header ? newProductionVal.images.header.uid : null
                };
                this.showForm = true;
            }
        }

    }
</script>
