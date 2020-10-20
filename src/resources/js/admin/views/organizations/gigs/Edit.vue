<template>
    <div class="row">
        <div class="col-8 offset-2">
            <b-form
                v-if="loaded"
                @submit.prevent="onSubmit">

                <b-form-group
                    label-for="gig_category_id"
                    :label="$t('gigs.attr.category')"
                    :invalid-feedback="invalidFeedback('gig_category_id')"
                    :state="getFieldState('gig_category_id')">

                    <b-form-select id="gig_category_id"
                                   v-model="form.gig_category_id"
                                   :options="categories"></b-form-select>
                </b-form-group>

                <b-form-group
                    :label="$t('gigs.attr.image')"
                    :description="$t('gigs.attr.image_description')"
                    :invalid-feedback="invalidFeedback('images.header.content')"
                    :state="getFieldState('images.header.content')"
                    label-for="header-img">
                    <div
                        v-if="hasHeaderImage"
                        class="overlay-container"
                        @click="removeHeaderImg()">
                        <img
                            class="img-fluid"
                            :src="form.images.header.urls.original"
                            :alt="$t('gigs.attr.image')">
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
                    label-for="description"
                    :label="$t('gigs.attr.description')"
                    :invalid-feedback="invalidFeedback('description')"
                    :state="getFieldState('description')"
                    :description="$t('gigs.attr.description_description')">
                    <b-form-textarea
                        id="description"
                        v-model="form.description"
                        type="text"
                        rows="10"/>
                </b-form-group>

                <b-form-group
                    label-for="link"
                    :label="$t('gigs.attr.link')"
                    :invalid-feedback="invalidFeedback('link')"
                    :state="getFieldState('link')"
                    :description="$t('gigs.attr.link_description')">
                    <b-form-input
                        id="link"
                        placeholder="https://"
                        v-model="form.link"
                        type="url"/>
                </b-form-group>

                <b-form-group
                    label-for="is_public"
                    :invalid-feedback="invalidFeedback('is_public')"
                    :state="getFieldState('is_public')"
                    :description="$t('gigs.attr.is_public_description')">
                    <b-form-checkbox
                        v-model="form.is_public"
                        name="is_public" >
                        {{ $t('gigs.attr.is_public') }}
                    </b-form-checkbox>
                </b-form-group>

                <b-button
                    type="submit"
                    variant="primary"
                    class="btn-block">
                    {{ $t('ui.edit') }}
                </b-button>
            </b-form>
        </div>
    </div>
</template>
<script>

export default {

    data() {
        return {
            loaded: false,
            errors: {},
            categories: [],
            form: {}
        };
    },
    computed: {
        hasHeaderImage: function () {
            return this.form.images && this.form.images.header && this.form.images.header.urls && this.form.images.header.urls.original;
        }
    },
    mounted() {
        this.loadGigad();
        this.loadCategories();
    },

    methods: {
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
        invalidFeedback(field) {
            if (!this.errors.hasOwnProperty(field) || !this.errors[field].length) {
                return '';
            }
            return this.errors[field][0];
        },
        getFieldState(field) {
            return !this.errors.hasOwnProperty(field);
        },
        onSubmit() {
            let self = this;
            axios.put(config.apiUrl + '/gigads/' + this.$route.params.uid, this.form)
                .then(() => {
                    self.$router.push({
                        name: 'organization.details',
                        params: {uid: this.form.organization_uid}
                    });
                }).catch(function (error) {
                self.errors = error.response.data.errors;
            });

        },
        loadCategories() {
            let self = this;
            axios.get(config.apiUrl + '/gigcategories')
                .then(response => {
                    for (let i = 0; i < response.data.data.length; i++) {
                        self.categories.push({
                            value: response.data.data[i].id,
                            text: response.data.data[i].name
                        });
                    }
                });
        },
        loadGigad() {
            let self = this;
            axios.get(config.apiUrl + '/gigads/' + this.$route.params.uid)
                .then(response => {
                    self.form = {
                        gig_category_id: response.data.data.category.id,
                        organization_uid: response.data.data.organization.uid,
                        is_public: response.data.data.is_public,
                        description: response.data.data.description || '',
                        link: response.data.data.link || '',
                        images: response.data.data.images
                    }
                    self.loaded = true;
                });
        }

    }
};
</script>
