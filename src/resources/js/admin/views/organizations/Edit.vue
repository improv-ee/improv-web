<template>
    <div class="row" v-if="form.name">
        <div class="col-10 offset-1">

            <b-form @submit.prevent="onSubmit">

                <b-form-group
                        :label="$t('organization.attr.name')"
                        :invalid-feedback="invalidFeedback('name')"
                        :state="getFieldState('name')"
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

                <b-form-group :label="$t('organization.image')"
                              :invalid-feedback="invalidFeedback('images.header.content')"
                              :state="getFieldState('images.header.content')"
                              label-for="header-img">

                    <div class="overlay-container"
                         v-if="hasHeaderImage"
                         @click="removeHeaderImg()">
                        <img class="img-fluid" :src="form.images.header.urls.original"
                             :alt="$t('organization.image')"/>
                        <div class="img-overlay">
                            <span><i class="far fa-trash-alt fa-10x"></i></span>
                        </div>
                    </div>


                    <b-form-file @change="uploadHeaderImg" v-else
                                 accept="image/jpeg, image/png, image/webp"
                                 :placeholder="$t('production.img.select_file')"></b-form-file>
                </b-form-group>


                <b-form-group
                        :label="$t('organization.attr.description')"
                        :invalid-feedback="invalidFeedback('description')"
                        :state="getFieldState('description')"
                        :description="$t('ui.markdown_supported')"
                        label-for="org-description">
                    <b-form-textarea id="org-description"
                                  type="text"
                                  rows="10"
                                  max-rows="30"
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
                form: {},
                errors: {}
            }
        },
        computed: {
            hasHeaderImage: function () {
                return this.form.images && this.form.images.header && this.form.images.header.urls && this.form.images.header.urls.original;
            }
        },
        methods: {
            getFieldState(field){
                return !this.errors.hasOwnProperty(field);
            },
            invalidFeedback(field) {
                if(!this.errors.hasOwnProperty(field) || !this.errors[field].length) {
                    return '';
                }
                return this.errors[field][0];
            },
            removeHeaderImg() {
                this.form.images.header['content'] = this.form.images.header.urls = null;
            },
            fileToBase64(file) {
                return new Promise((resolve, reject) => {
                    const reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = () => resolve(reader.result);
                    reader.onerror = error => reject(error);
                });
            },
            uploadHeaderImg(e) {
                let self = this;
                this.fileToBase64(e.srcElement.files[0]).then(data => self.form.images = {header: {content: data}});
            },

            onSubmit() {
                let self = this;

                axios.put(config.apiUrl + '/organizations/' + this.$route.params.slug, this.form)
                    .then(function (response) {

                        self.$router.push({
                            name: 'organization.details',
                            params: {slug: response.data.data.slug}
                        });
                        self.errors = {};
                    })
                    .catch(function(error){
                        self.errors = error.response.data.errors;
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
                        is_public: this.organization.is_public,
                        images: {
                            header: {
                                urls: {
                                    original: this.organization.hasOwnProperty('images') && this.organization.images.header !== null ? this.organization.images.header.urls.original : null
                                }
                            }
                        }
                    }
                });
        },

    }
</script>
