<template>
  <div class="row">
    <div class="col-lg-4 offset-lg-8">
      <b-button-toolbar
        key-nav
        class="float-right">
        <b-button-group class="mx-1">
          <router-link
            v-if="showEdit"
            :to="editLink"
            class="btn btn-sm btn-primary">
            <i class="far fa-edit" /> {{ $t("ui.edit") }}
          </router-link>
          <b-button
            v-if="showDelete"
            size="sm"
            variant="danger"
            @click="markAsDeleted">
            <i class="far fa-trash-alt" /> {{ $t("ui.delete") }}
          </b-button>
        </b-button-group>
      </b-button-toolbar>
    </div>
  </div>
</template>
<script>
export default {
    props: {
        resourceName: {type: String, default: ''},
        resourceId: {type: String, default: ''},
        deleteRedirect: {
            type: [String, Object],
            default: ''
        },
        showDelete: {type: Boolean, default: true},
        showEdit: {type: Boolean, default: true}
    },
    data: function () {
        return {};
    },
    computed: {
        editLink: function () {
            return '/' + this.resourceName + '/' + this.resourceId + '/edit';
        },
        deletePath: function () {
            return config.apiUrl + '/' + this.resourceName + '/' + this.resourceId;
        },
        deleteRedirectUri: function () {
            return this.deleteRedirect !== '' ? this.deleteRedirect : {name: this.resourceName};
        }

    },
    methods: {
        markAsDeleted() {
            let self = this;
            axios.delete(this.deletePath)
                .then(function(){
                    self.$router.push(self.deleteRedirectUri);
                });
        }
    }
};
</script>