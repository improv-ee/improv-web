<template>
  <div class="row">
    <div class="col-10 offset-1">
      <b-form
        v-if="showForm"
        @submit.prevent="onSubmit">
        <b-form-group
          :label="$t('production.attr.title')"
          label-for="title"
          :invalid-feedback="invalidFeedback('title')"
          :state="getFieldState('title')"
          :description="$t('production.attr.title_description')">
          <b-form-input
            id="title"
            v-model="form.title"
            type="text"
            required />
        </b-form-group>

        <b-form-group
          :label="$t('production.img.header')"
          label-for="header-img"

          :description="$t('production.img.header_description')">
          <div
            v-if="hasHeaderImage"
            class="overlay-container"
            @click="removeHeaderImg()">
            <img
              class="img-fluid"
              :src="form.images.header.urls.original"
              :alt="$t('production.img.header')">
            <div class="img-overlay">
              <span><i class="far fa-trash-alt fa-10x" /></span>
            </div>
          </div>


          <b-form-file
            v-else
            accept="image/jpeg, image/png, image/webp"
            :placeholder="$t('production.img.select_file')"
            @change="uploadHeaderImg" />
        </b-form-group>

        <b-form-group
          :label="$t('production.attr.excerpt')"
          :invalid-feedback="invalidFeedback('excerpt')"
          :state="getFieldState('excerpt')"
          :description="$t('production.attr.excerpt_description')"
          label-for="excerpt">
          <b-form-textarea
            id="excerpt"
            v-model="form.excerpt"
            type="text"
            rows="4" />
        </b-form-group>
        <b-form-group
          :label="$t('production.attr.description')"
          :description="ui.help.description"
          :invalid-feedback="invalidFeedback('description')"
          :state="getFieldState('description')"
          label-for="description">
          <b-form-textarea
            id="description"
            v-model="form.description"
            type="text"
            rows="10"
            required />
        </b-form-group>

        <b-form-group
          :label="$t('event.attr.organizers')"
          :description="$t('production.attr.organizers_description')"
          :invalid-feedback="invalidFeedback('organizations')"
          :state="getFieldState('organizations')"
          label-for="production-organizers">
          <multi-select
            v-model="form.organizations"
            options-api-path="/organizations"
            :options="production.organizations" />
        </b-form-group>


        <b-form-group
          :label="$t('event.attr.tags')"
          :description="$t('production.attr.tags_description')"
          :invalid-feedback="invalidFeedback('tags')"
          :state="getFieldState('tags')"
          label-for="production-tags">
          <multi-select
            v-model="form.tags"
            options-api-path="/tags"
            :options="production.tags" />
        </b-form-group>

        <b-button
          type="submit"
          variant="primary"
          class="btn-block">
          {{ mode === 'edit' ? $t('ui.edit') :
            $t('ui.create') }}
        </b-button>
      </b-form>
    </div>
  </div>
</template>

<script>
import MultiSelect from '../MultiSelect';

export default {
    components: {MultiSelect},
    props: {
        'production': {
            type: Object,
            default: function () {
                return {};
            }
        },
        'mode': {
            'type': String,
            'default': 'create'
        }
    },
    data() {
        return {
            form: {
                organizations: [],
                tags: []
            },
            ui: {},
            showForm: false,
            errors: {}
        };
    },
    computed: {
        hasHeaderImage: function () {
            return this.form.images && this.form.images.header && this.form.images.header.urls && this.form.images.header.urls.original;
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
                organizations: newProductionVal.organizations,
                tags: newProductionVal.tags,
                images: {
                    header: {
                        urls: {
                            original: newProductionVal.hasOwnProperty('images') && newProductionVal.images.header !== null ? newProductionVal.images.header.urls.original : null
                        }
                    }
                }
            };
            this.showForm = true;
        }
    },
    mounted() {
        this.ui = {
            help: {
                description: this.$t('production.attr.description_description') + ' ' + this.$t('ui.markdown_supported')
            }
        };
        if (this.mode === 'create') {
            this.showForm = true;
        }
    },

    methods: {
        getFieldState(field) {
            return !this.errors.hasOwnProperty(field);
        },
        invalidFeedback(field) {
            if (!this.errors.hasOwnProperty(field) || !this.errors[field].length) {
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

        create() {
            let self = this;

            axios.post(config.apiUrl + '/productions', this.form)
                .then(function (response) {

                    self.$router.push({
                        name: 'production.details',
                        params: {uid: response.data.data.uid}
                    });
                    self.errors = {};

                }).catch(function (error) {

                    let text = error.response.status === 422 ? self.$t('ui.validation_error') : self.$t('ui.server_error_message');

                    self.$notify({
                        type: 'error',
                        group: 'app',
                        title: text
                    });

                    self.errors = error.response.data.errors;

                });
        },
        edit() {
            let self = this;

            axios.put(config.apiUrl + '/productions/' + self.production.uid, this.form)
                .then(function (response) {

                    self.$router.push({
                        name: 'production.details',
                        params: {uid: response.data.data.uid}
                    });
                }).catch(function (error) {
                    let text = error.response.status === 422 ? self.$t('ui.validation_error') : self.$t('ui.server_error_message');
                    self.$notify({
                        type: 'error',
                        group: 'app',
                        title: self.$t('ui.server_error'),
                        text: text
                    });

                });
        },
        onSubmit() {
            if (this.mode === 'edit') {
                this.edit();
            } else {
                this.create();
            }
        }
    }

};
</script>
