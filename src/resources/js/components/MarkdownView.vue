<template>
  <div class="row">
    <div
      class="col-sm">
      <vue-markdown :source="content" />
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
        view: {
            type: String,
            default: ''
        },
        title: {
            type: String,
            default: ''
        }
    },
    data() {
        return {
            content: ''
        };
    },
    mounted() {
        this.loadContent(this.view);
    },
    methods: {

        loadContent(view) {
            let self = this;
            axios.get('/markdown/' + window.config.languages.current + '/' + view)
                .then(response => {
                    self.content = response.data;
                })
                .catch(function () {
                    self.content = self.$t('ui.page_not_found');
                });
        }
    },
    metaInfo() {
        return {
            title: this.title
        };
    }
};
</script>