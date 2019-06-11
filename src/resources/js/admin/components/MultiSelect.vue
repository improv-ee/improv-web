<template>
  <multiselect
    v-model="selectedItems"
    label="name"
    :track-by="trackBy"
    :placeholder="$t('ui.search.type_to_search')"
    :select-label="$t('ui.search.press_to_select')"
    open-direction="bottom"
    :options="selectableOptions"
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
        v-if="selectedItems.length"
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
        optionsApiPath:{
            type: String,
            required: true
        },
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
        },
        trackBy: {
            type: String,
            required: true,
            default: 'uid'
        }
    },
    data() {
        return {
            selectedItems: [],
            selectableOptions: [],
            isLoading: false
        };
    },
    watch: {
        selectedItems: function () {

            let items = lodash.map(this.selectedItems, function (item) {
                return item[this.trackBy];
            });

            this.$emit('input', items);
        }
    },
    mounted() {
        this.selectedItems = this.value;
        this.selectableOptions = this.options;

        // Do an initial search for options with an empty query on component load
        // This pre-loads a list of options, so that when the selectbox is first
        // opened, it would be populated with possible options
        this.asyncFind('');
    },
    methods: {
        limitText(count) {
            return this.$t('ui.search.and_number_others', {number: count});
        },

        asyncFind: lodash.debounce(function (query) {
            this.isLoading = true;
            this.findOptions(query).then(response => {
                this.selectableOptions = response;
                this.isLoading = false;
            });
        }, 300),
        clearAll() {
            this.selectedItems = [];
        },
        findOptions(query) {
            return new Promise((resolve, reject) => {
                let self = this;
                axios.get(config.apiUrl + this.optionsApiPath, {params: {'filter[name]': query}})
                    .then(function (response) {
                        let options = lodash.map(response.data.data, function (item) {
                            return lodash.pick(item, ['name', self.trackBy]);
                        });

                        resolve(options);
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
