<template>
<div class="row">
  <div class="col-8 offset-2">


    <b-form @submit="onSubmit">

      <b-form-group
                    :label="$t('production.attr.title')"
                    label-for="title"
                    :description="$t('production.attr.title_description')">
        <b-form-input id="title"
                      type="text"
                      v-model="production.title"
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
                      v-model="production.excerpt"
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
                      v-model="production.description"
                      required
                      :placeholder="$t('production.attr.description_placeholder')">
        </b-form-textarea>
      </b-form-group>

      <b-button type="submit" variant="primary" class="btn-block">{{ buttonLabel }}</b-button>
    </b-form>


  </div>
</div>
</template>

<script>

    export default {
        props: ['production'],
        data () {
            return {

                operation: this.$route.params.slug ? 'update' : 'create'
            }
        },
        computed: {
            buttonLabel: function () {
                return this.operation === 'update' ? this.$t('ui.edit') : this.$t('ui.create')
            }},
        methods: {
            onSubmit (evt) {
                evt.preventDefault();
                if (this.operation) {
                    axios.put('/api/productions/' + this.$route.params.slug, this.production)
                        .then(function (response) {
                            console.log(response.data);
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }else {
                axios.post('/api/productions', this.production)
                    .then(function (response) {
                        console.log(response.data);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
            }
        }

    }
</script>
