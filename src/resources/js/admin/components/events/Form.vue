<template>
    <div class="row">
        <div class="col-8 offset-2">

            <h2></h2>
            <b-form @submit.prevent="onSubmit" v-if="form.times">

                <b-form-group :label="$t('event.attr.start_time')" label-for="start_time"
                              :description="$t('event.attr.start_time_description')">
                    <date-picker v-model="form.times.start" required></date-picker>
                </b-form-group>

                <b-form-group :label="$t('event.attr.end_time')" label-for="end_time"
                              :description="$t('event.attr.end_time_description')">

                    <date-picker v-model="form.times.end" required></date-picker>

                </b-form-group>

                <b-form-group
                        :label="$t('production.attr.title')"
                        label-for="title"
                        :description="$t('production.attr.title_description')">
                    <b-form-input id="title"
                                  type="text"
                                  v-model="form.title"
                                  :placeholder="$t('production.attr.title_placeholder')">
                    </b-form-input>
                </b-form-group>

                <b-form-group
                        :label="$t('production.attr.description')"
                        :description="$t('production.attr.description_description')"
                        label-for="description">
                    <b-form-textarea id="description"
                                     type="text" rows="10"
                                     v-model="form.description"
                                     :placeholder="$t('production.attr.description_placeholder')">
                    </b-form-textarea>
                </b-form-group>

                <b-button type="submit" variant="primary" class="btn-block">{{ $t('ui.edit') }}</b-button>
            </b-form>

        </div>
    </div>
</template>

<script>
    import { dom } from '@fortawesome/fontawesome-svg-core'
    export default {
        props: ['event'],
        data() {
            return {
                form: {}
            }
        },

        methods: {
            onSubmit(evt) {
                let self = this;
                axios.put('/api/events/' + this.$route.params.uid, this.form)
                    .then(function (response) {

                        self.$router.push({
                            name: 'event.details',
                            params: {uid: self.$route.params.uid}
                        })
                    });
            }
        },
        watch: {

            // When the component initializes, the event prop is not yet populated,
            // it will be fetched with async request. Wait for it to complete, then set initial form
            // state to those values
            event: function (event) {

                this.form = {
                    title: event.title,
                    description: event.description,
                    excerpt: event.excerpt,
                    times: {end: moment(event.times.end), start:moment(event.times.start)}
                }
            }
        },

        mounted() {
            dom.watch();
        }

    }
</script>
