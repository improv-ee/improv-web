<template>
    <div>
        <b-table
            v-if="loaded"
            striped
            outlined
            responsive
            hover
            :items="items"
            :fields="fields">
            <template
                #cell(uid)="data">
                <router-link class="btn"
                    :to="{ name: 'gigads.edit', params: { uid: data.item.uid }}">
                    {{ $t('ui.edit') }}
                </router-link>
            </template>
        </b-table>
        <b-button
            variant="primary"
            @click="addGigad">
            {{ $t('ui.add_new') }}
        </b-button>
    </div>
</template>
<script>
var moment = require('moment');

export default {

    data() {
        return {
            items: [],
            loaded: false,
            fields: [
                {
                    key: 'category',
                    sortable: true
                },
                {
                    key: 'is_public',
                    sortable: true
                },
                {
                    key: 'updated_at',
                    sortable: true
                },
                {
                    key: 'uid',
                    sortable: false,
                    formatter: 'uid',
                    label: ''
                }
            ]
        };
    },

    mounted() {
        this.fields[0].label = this.$i18n.t('gigs.attr.category');
        this.fields[1].label = this.$i18n.t('gigs.attr.is_public');
        this.fields[2].label = this.$i18n.t('gigs.attr.updated_at');
        this.loadGigs();
    },
    methods: {
        addGigad() {
            let self = this;
            axios.post(config.apiUrl + '/gigads', {
                gig_category_id: 1,
                organization_uid: this.$route.params.uid,
                is_public: false
            })
                .then(response => {
                    self.$router.push({
                        name: 'gigads.edit',
                        params: {uid: response.data.data.uid}
                    });
                });
        },
        loadGigs() {
            let self = this;
            axios.get(config.apiUrl + '/gigads', {params: {'onlyMine': 1}})
                .then(response => {
                    for (let i = 0; i < response.data.data.length; i++) {
                        let gigad = response.data.data[i];

                        self.items.push({
                            'uid': gigad.uid,
                            'updated_at': moment(gigad.times.updated_at).format('Do MMMM HH:mm'),
                            'is_public': gigad.is_public ? this.$i18n.t('lang.yes') : this.$i18n.t('lang.no'),
                            'category': gigad.category.name
                        });
                    }
                    self.loaded = true;
                });
        }

    }
};
</script>
