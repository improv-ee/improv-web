<template>
    <div class="row">
        <div class="col-lg-4 offset-lg-8">
            <b-button-toolbar key-nav class="float-right">
                <b-button-group class="mx-1">
                    <router-link :to="editLink" v-if="this.showEdit"
                                 class="btn btn-sm btn-secondary">{{ $t("ui.edit") }}
                    </router-link>
                    <b-button size="sm" @click="markAsDeleted" v-if="this.showDelete" variant="danger">{{ $t("ui.delete") }}</b-button>
                </b-button-group>
            </b-button-toolbar>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            resourceName: String,
            resourceId: String,
            deleteRedirect: {
                type: [String, Object],
                default: ''
            },
            showDelete: Boolean,
            showEdit: Boolean
        },
        data: function () {
            return {}
        },
        computed: {
            editLink: function () {
                return '/' + this.resourceName + '/' + this.resourceId + '/edit';
            },
            deletePath: function () {
                return '/api/' + this.resourceName + '/' + this.resourceId;
            },
            deleteRedirectUri: function () {
                return this.deleteRedirect !== '' ? this.deleteRedirect : {name: this.resourceName};
            }

        },
        methods: {
            markAsDeleted() {
                let self = this;
                axios.delete(this.deletePath)
                    .then(response => {
                        self.$router.push(self.deleteRedirectUri)
                    });
            }
        }
    }
</script>