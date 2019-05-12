<template>
  <multiselect
    v-model="selectedTags"
    label="name"
    track-by="slug"
    :placeholder="$t('ui.search.type_to_search')"
    :select-label="$t('ui.search.press_to_select')"
    open-direction="bottom"
    :options="tags"
    :multiple="true"
    :searchable="true"
    :loading="isLoading"
    :internal-search="false"
    :clear-on-select="false"
    :close-on-select="false"
    :options-limit="20"
    :limit="20"
    :limit-text="limitText"
    :max-height="600"
    :show-no-results="false"
    :hide-selected="true"
    @search-change="asyncFind">
    <template
      slot="clear"
      slot-scope="props">
      <div
        v-if="selectedTags.length"
        class="multiselect__clear"
        @mousedown.prevent.stop="clearAll(props.search)" />
    </template>
    <span slot="noResult">{{ $t('ui.search.no_results') }}</span>
    <span slot="noOptions">{{ $t('ui.search.no_results') }}</span>
  </multiselect>
</template>

<script>
import Multiselect from 'vue-multiselect';
import lodash from 'lodash';

export default {
    components: {Multiselect},
    props: {
        value: {
            type: Array,
            default: function () {
                return [];
            }
        },
        options: {
            type: Array,
            default: function () {
                return [];
            }
        }
    },
    data() {
        return {
            selectedTags: [],
            tags: [],
            isLoading: false
        };
    },
    watch: {
        selectedTags: function () {

            let slugs = lodash.map(this.selectedTags, function (organization) {
                return organization.slug;
            });

            this.$emit('input', slugs);
        }
    },
    mounted() {
        this.selectedTags = this.value;
        this.tags = this.options;
    },
    methods: {
        limitText(count) {
            return this.$t('ui.search.and_number_others', {number: count});
        },

        asyncFind: lodash.debounce(function (query) {
            this.isLoading = true;
            this.findTag(query).then(response => {
                this.tags = response;
                this.isLoading = false;
            });
        }, 300),
        clearAll() {
            this.selectedTags = [];
        },
        findTag(query) {
            return new Promise((resolve, reject) => {
                axios.get(config.apiUrl + '/tags', {params: {'filter[name]': query}})
                    .then(function (response) {

                        let tags = lodash.map(response.data.data, function (organization) {
                            return lodash.pick(organization, ['name', 'slug']);
                        });

                        resolve(tags);
                    })
                    .catch(function () {
                        reject();
                    });
            });
        }
    }
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
