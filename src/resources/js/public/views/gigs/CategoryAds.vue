<template>
    <div class="row" v-if="loaded">
        <div v-for="gig in gigs" class="col-12">
            <div class="card card-cascade wider mb-4">

                <!-- Card image -->
                <div class="view view-cascade overlay">
                    <img class="card-img-top" src="/img/production/default-header.jpg" alt="Card image cap">
                    <a :href="gig.link">
                        <div class="mask rgba-white-slight"></div>
                    </a>
                </div>

                <!-- Card content -->
                <div class="card-body card-body-cascade text-center">

                    <!-- Title -->
                    <h4 class="card-title"><strong>{{ gig.organization.name }}</strong></h4>

                    <!-- Text -->
                    <p class="card-text">{{ gig.description }}</p>

                    <a class="btn btn-primary btn-lg btn-block" :href="gig.link"><i class="fas fa-external-link-alt" /> {{ $t('gig.visit_advertiser') }}</a>

                </div>

            </div>
        </div>

    </div>
</template>


<script>
export default {

    data() {
        return {
            gigs: [],
            loaded: false
        };
    },
    mounted() {
        this.getResults();
    },
    props: {
        categoryId: {
            type: Number
        }
    },
    methods: {

        getResults() {
            let self = this;

            axios.get(config.apiUrl + '/gigads', {params: {'filter[gig_category_id]': self.categoryId}})
                .then(response => {
                    self.gigs = response.data.data;
                    self.loaded = true;
                });
        }
    }
};
</script>
