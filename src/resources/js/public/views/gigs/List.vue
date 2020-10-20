<template>
  <div>
    <div
      v-if="loaded"
      class="row">
      <div
        v-for="category in categories"
        :key="category.id"
        class="col-12">
        <div v-if="category.ads > 0">
          <h3>{{ category.name }}</h3>

          <p class="lead">
            {{ category.description }}
          </p>
          <category-ads :category-id="category.id" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import CategoryAds from './CategoryAds';

export default {
    components: {
        CategoryAds
    },
    data() {
        return {
            categories: [],
            loaded: false
        };
    },
    mounted() {
        this.getResults();
    },
    methods: {

        getResults() {
            let self = this;
            axios.get(config.apiUrl + '/gigcategories')
                .then(response => {
                    self.categories = response.data.data;
                    self.loaded = true;
                });
        }
    },
    metaInfo() {
        return {
            title: this.$t('nav.gigs')
        };
    }
};
</script>
