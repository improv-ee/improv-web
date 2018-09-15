<template>
    <b-button-toolbar key-nav>
        <b-button-group class="mx-1">
            <router-link :to="editLink"
                         class="btn btn-sm btn-outline-secondary">{{ $t("ui.edit") }}
            </router-link>
            <b-button size="sm" @click="markAsDeleted" variant="outline-danger">{{ $t("ui.delete") }}</b-button>
        </b-button-group>
    </b-button-toolbar>
</template>
<script>
    export default {
        props: {
            resourceName: String,
            resourceId: String,
            deleteRedirect: {
                type: [String, Object],
                default: ''
            }
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