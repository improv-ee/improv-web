<template>
  <div class="row">
    <div class="col-8 offset-2">
      <h2 />
      <b-form
        v-if="form.times"
        @submit.prevent="onSubmit">
        <b-form-group
          :label="$t('event.attr.start_time')"
          label-for="start_time"
          :invalid-feedback="invalidFeedback('times.start')"
          :state="getFieldState('times.start')"
          :description="$t('event.attr.start_time_description')">
          <date-picker
            v-model="form.times.start"
            required />
        </b-form-group>

        <b-form-group
          :label="$t('event.attr.end_time')"
          label-for="end_time"
          :description="$t('event.attr.end_time_description')"
          :invalid-feedback="invalidFeedback('times.end')"
          :state="getFieldState('times.end')">
          <date-picker
            v-model="form.times.end"
            required />
        </b-form-group>

        <b-form-group
          :label="$t('event.attr.title')"
          label-for="title"
          :invalid-feedback="invalidFeedback('title')"
          :state="getFieldState('title')"
          :description="$t('event.attr.title_description')">
          <b-form-input
            id="title"
            v-model="form.title"
            type="text" />
        </b-form-group>

        <b-form-group
          :label="$t('event.attr.description')"
          :invalid-feedback="invalidFeedback('description')"
          :state="getFieldState('description')"
          :description="$t('event.attr.description_description')"
          label-for="description">
          <b-form-textarea
            id="description"
            v-model="form.description"
            type="text"
            rows="10" />
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
	props: {
		event: {
			type: Object,
			default: function () {
				return {};
			}
		}
	},
	data() {
		return {
			form: {},
			errors: {}
		};
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
				times: {end: moment(event.times.end), start: moment(event.times.start)}
			};
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
		onSubmit() {
			let self = this;
			axios.put(config.apiUrl + '/events/' + this.$route.params.uid, this.form)
				.then(function () {

					self.$router.push({
						name: 'event.details',
						params: {uid: self.$route.params.uid}
					});
					self.errors = {};
				})
				.catch(function (error) {
					self.errors = error.response.data.errors;
				});
		}
	}

};
</script>
