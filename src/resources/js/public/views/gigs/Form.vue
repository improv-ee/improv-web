<template>
    <div>


        <h3>Etendused</h3>




        <!-- Card Wider -->
        <div class="card card-cascade wider">

            <!-- Card image -->
            <div class="view view-cascade overlay">
                <img class="card-img-top" src="/img/production/default-header.jpg" alt="Card image cap">
                <a href="#!">
                    <div class="mask rgba-white-slight"></div>
                </a>
            </div>

            <!-- Card content -->
            <div class="card-body card-body-cascade text-center">

                <!-- Title -->
                <h4 class="card-title"><strong>Alison Belmont</strong></h4>
                <!-- Subtitle -->
                <h5 class="blue-text pb-2"><strong>Graffiti Artist</strong></h5>
                <!-- Text -->
                <p class="card-text">Sed ut perspiciatis unde omnis iste natus sit voluptatem accusantium doloremque
                    laudantium, totam rem aperiam. </p>

                <!-- Linkedin -->
                <a class="px-2 fa-lg li-ic"><i class="fab fa-linkedin-in"></i></a>
                <!-- Twitter -->
                <a class="px-2 fa-lg tw-ic"><i class="fab fa-twitter"></i></a>
                <!-- Dribbble -->
                <a class="px-2 fa-lg fb-ic"><i class="fab fa-facebook-f"></i></a>

            </div>

        </div>
        <!-- Card Wider -->




        <h3>Töötoad</h3>

        <h3>Õhtujuht</h3>

        <h3>Meeskonnakoolitus</h3>

        <h3>Impronäitleja</h3>
    </div>
</template>

<script>
export default {

    data() {
        return {
            organizations: [],
        };
    },
    mounted() {
        this.getResults();
    },
    methods: {

        getResults(page = 1) {
            axios.get(config.apiUrl + '/organizations', {params: {page: page, 'filter[is_public]': 1}})
                .then(response => {
                    this.organizations = response.data.data;
                });
        }
    },
    metaInfo () {
        return {
            title: this.$t('nav.gigs')
        };
    }
};
</script>
