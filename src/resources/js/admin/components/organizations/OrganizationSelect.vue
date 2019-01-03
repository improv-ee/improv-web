<template>
    <multiselect v-model="selectedOrganizations" label="name" track-by="slug"
                 :placeholder="$t('ui.search.type_to_search')" :selectLabel="$t('ui.search.press_to_select')"
                 open-direction="bottom" :options="organizations" :multiple="true" :searchable="true"
                 :loading="isLoading" :internal-search="false" :clear-on-select="false" :close-on-select="false"
                 :options-limit="20" :limit="20" :limit-text="limitText" :max-height="600" :show-no-results="false"
                 :hide-selected="true" @search-change="asyncFind">

        <template slot="clear" slot-scope="props">
            <div class="multiselect__clear" v-if="selectedOrganizations.length"
                 @mousedown.prevent.stop="clearAll(props.search)"></div>
        </template>
        <span slot="noResult">{{ $t('ui.search.no_results') }}</span>
        <span slot="noOptions">{{ $t('ui.search.no_results') }}</span>
    </multiselect>
</template>

<script>
    import Multiselect from 'vue-multiselect';

    export default {
        components: {Multiselect},
        props: ['value', 'options'],
        data() {
            return {
                selectedOrganizations: [],
                organizations: [],
                isLoading: false
            }
        },

        methods: {
            limitText(count) {
                return $t('ui.search.and_number_others', {number: count});
            },

            asyncFind: _.debounce(function (query) {
                this.isLoading = true;
                this.findOrganization(query).then(response => {
                    this.organizations = response;
                    this.isLoading = false
                })
            }, 300),
            clearAll() {
                this.selectedOrganizations = [];
            },
            findOrganization(query) {
                return new Promise((resolve, reject) => {
                    axios.get(config.apiUrl + '/organizations', {params: {'filter[name]': query}})
                        .then(function (response) {

                            let organizations = _.map(response.data.data, function (organization) {
                                return _.pick(organization, ['name', 'slug']);
                            });

                            resolve(organizations);
                        })
                        .catch(function () {
                            reject();
                        });
                })
            }
        },
        watch: {
            selectedOrganizations: function () {

                let slugs = _.map(this.selectedOrganizations, function (organization) {
                    return organization.slug;
                });

                this.$emit('input', slugs);
            }
        },
        mounted() {
            this.selectedOrganizations = this.value;
            this.organizations = this.options;
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
