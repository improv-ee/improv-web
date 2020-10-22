<template>
  <div
    v-if="loaded"
    class="row">
    <div
      v-for="gig in gigs"
      :key="gig.uid"
      class="col-12">
      <div class="card card-cascade wider mb-5">
        <!-- Card image -->
        <div class="view view-cascade overlay">
          <img
            class="card-img-top"
            :src="getCardImage(gig)"
            alt="Header image">
          <a
            :href="gig.link"
            target="_blank">
            <div class="mask rgba-white-slight" />
          </a>
        </div>

        <!-- Card content -->
        <div class="card-body card-body-cascade text-center">
          <!-- Title -->
          <h4 class="card-title">
            <strong>{{ gig.organization.name }}</strong>
          </h4>

          <!-- Text -->
          <div class="card-text">
            <vue-markdown :source="gig.description" />
          </div>

          <a
            class="btn btn-primary btn-lg btn-block"
            target="_blank"
            :href="gig.link"><i class="fas fa-external-link-alt" /> {{ $t('gig.visit_advertiser') }}</a>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import VueMarkdown from 'vue-markdown';

export default {
    components: {
        VueMarkdown
    },
    props: {
        categoryId: {
            type: Number,
            default: 0
        }
    },

    data() {
        return {
            gigs: [],
            loaded: false
        };
    },
    mounted() {
        this.getResults();
    },
    methods: {

        getCardImage(gigad) {
            if (gigad.images && gigad.images.header && gigad.images.header.urls) {
                return gigad.images.header.urls.original;
            }
            return '/img/production/default-header.jpg';
        },
        getResults() {
            let self = this;

            axios.get(config.apiUrl + '/gigads', {params: {'filter[gig_category_id]': self.categoryId, 'filter[is_public]': 1}})
                .then(response => {
                    self.gigs = response.data.data;
                    self.loaded = true;
                });
        }
    }
};
</script>
