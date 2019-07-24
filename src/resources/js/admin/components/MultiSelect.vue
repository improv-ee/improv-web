<template>
  <multiselect
    v-model="selectedItems"
    label="name"
    :track-by="trackBy"
    :placeholder="$t('ui.search.type_to_search')"
    :select-label="$t('ui.search.press_to_select')"
    open-direction="bottom"
    :options="selectableOptions"
    :multiple="multiple"
    :searchable="true"
    :loading="isLoading"
    :internal-search="false"
    :clear-on-select="clearOnSelect"
    :close-on-select="closeOnSelect"
    :options-limit="20"
    :limit="20"
    :after-list-template="null"
    :limit-text="limitText"
    :max-height="600"
    :show-no-results="false"
    :hide-selected="true"
    @select="optionSelected"
    @search-change="asyncFind">
    <template
      slot="clear"
      slot-scope="props">
      <div
        v-if="selectedItems.length"
        class="multiselect__clear"
        @mousedown.prevent.stop="clearAll(props.search)" />
    </template>
    <template
      v-if="afterListTemplate !== null"
      slot="afterList">
      <!--  eslint-disable-next-line vue/no-v-html -->
      <div v-html="afterListTemplate" />
    </template>
    <span slot="noResult">{{ $t('ui.search.no_results') }}</span>
    <span slot="noOptions">{{ $t('ui.search.no_results') }}</span>
  </multiselect>
</template>

<script>
import Multiselect from 'vue-multiselect';
import lodash from 'lodash';
import uuid from 'uuid';

export default {
    components: {Multiselect},
    props: {
        optionsApiPath:{
            type: String,
            required: true
        },
        afterListTemplate: {
            type: String,
            default: null
        },
        closeOnSelect: {
            type: Boolean,
            default: false
        },
        clearOnSelect: {
            type: Boolean,
            default: false
        },
        multiple:{
            type: Boolean,
            default: true
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
        },
        prefetchResults: {
            type: Boolean,
            default: true
        }
    },
    data() {
        return {
            selectedItems: [],
            selectableOptions: [],
            isLoading: false,

            // A session token is a UUID that uniquely identifies a single autocomplete/search session
            // When an option is selected, the token resets
            sessionToken: null
        };
    },
    watch: {
        selectedItems: function () {

            if (!this.multiple) {
                this.$emit('input', this.selectedItems);
                return;
            }

            let self = this;
            let items = lodash.map(this.selectedItems, function (item) {
                return item[self.trackBy];
            });
            this.$emit('input', items);
        }
    },
    mounted() {
        this.selectedItems = this.value;
        this.selectableOptions = this.options;

        this.sessionToken = uuid();

        // Do an initial search for options with an empty query on component load
        // This pre-loads a list of options, so that when the selectbox is first
        // opened, it would be populated with possible options
        if (this.prefetchResults) {
            this.asyncFind('');
        }
    },
    methods: {
        limitText(count) {
            return this.$t('ui.search.and_number_others', {number: count});
        },

        asyncFind: lodash.debounce(function (query) {

            if (query === '') {
                return;
            }

            this.isLoading = true;
            this.findOptions(query).then(response => {
                this.selectableOptions = response;
                this.isLoading = false;
            });
        }, 600),
        clearAll() {
            this.selectedItems = [];
        },
        optionSelected(){
            this.sessionToken = uuid();
        },
        findOptions(query) {
            return new Promise((resolve, reject) => {
                let self = this;
                axios.get(config.apiUrl + this.optionsApiPath, {params: {'filter[name]': query, session: this.sessionToken}})
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
