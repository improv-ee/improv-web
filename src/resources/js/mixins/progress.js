// Config for vue-progressbar component (show loading bar)
// Used as a mixin in public and admin App.vue components
export const progress = {
    mounted () {
        //  [App.vue specific] When App.vue is finish loading finish the progress bar
        this.$Progress.finish()
    },
    created () {
        //  [App.vue specific] When App.vue is first loaded start the progress bar
        this.$Progress.start();
        //  hook the progress bar to start before we move router-view
        this.$router.beforeEach((to, from, next) => {
            //  does the page we want to go to have a meta.progress object
            if (to.meta.progress !== undefined) {
                let meta = to.meta.progress;
                // parse meta tags
                this.$Progress.parseMeta(meta)
            }
            //  start the progress bar
            this.$Progress.start();
            //  continue to next page
            next();
        });
        //  hook the progress bar to finish after we've finished moving router-view
        this.$router.afterEach((to, from) => {
            //  finish the progress bar
            this.$Progress.finish();
        });

        // before a request is made start the loading indicator
        window.axios.interceptors.request.use(config => {
            this.$Progress.start();
            return config;
        });

        // before a response is returned stop loading indicator
        window.axios.interceptors.response.use(response => {
            this.$Progress.finish();
            return response;
        });
    }
};