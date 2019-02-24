// Config for vue-progressbar component (show loading bar)
// Used as a mixin in public and admin App.vue components
export const progress = {

    created () {

        window.axios.interceptors.request.use(config => {
            this.$Progress.start();
            return config;
        });

        window.axios.interceptors.response.use(response => {
            this.$Progress.finish();
            return response;
        });
    }
};