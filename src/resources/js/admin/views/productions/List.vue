<template>
  <div v-if="loaded">
    <p
      v-if="organizations.length === 0"
      class="alert alert-danger">
      {{ $t('production.you_dont_belong_to_any_org') }}
    </p>
    <div v-else>
      <p>{{ $t('production.list_intro') }}</p>

      <p class="text-right">
        <b-button
          :to="{name: 'production.create'}"
          variant="primary"
          class="btn btn-sm mb-3">
          {{ $t("production.create_new") }}
        </b-button>
      </p>

      <div v-if="productions.data && productions.data.length">
        <div class="table-responsive">
          <table class="table table-sm table-hover table-clickable">
            <thead class="thead-light">
              <tr>
                <th>{{ $t("production.attr.title") }}</th>
                <th>{{ $t("production.num_of_events") }}</th>
              </tr>
            </thead>
            <tbody>
              <production-table-row
                v-for="production in productions.data"
                :key="production.uid"
                :production="production" />
            </tbody>
          </table>
        </div>
        <pagination
          v-if="productions.meta"
          :data="productions.meta"
          class="justify-content-center"
          @pagination-change-page="getResults" />
      </div>
    </div>
  </div>
</template>

<script>
export default {
    data() {
        return {
            productions: {},
            newProductionTitle: ' ',
            organizations: {},
            loaded: false
        };
    },
    mounted() {
        this.getResults();
        this.getOrganizations();
    },
    methods: {

        getResults(page = 1) {
            this.$Progress.start();
            axios.get(config.apiUrl + '/productions?onlyMine=true', {params: {page: page}})
                .then(response => {
                    this.productions = response.data;
                    this.loaded = true;
                    this.$Progress.finish();
                });
        },

        getOrganizations() {
            axios.get(config.apiUrl + '/organizations?onlyMine=true')
                .then(response => {
                    this.organizations = response.data.data;
                });
        }
    }
};
</script>
