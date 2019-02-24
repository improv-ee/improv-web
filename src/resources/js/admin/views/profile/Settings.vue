<template>
    <div class="row">
        <side-nav></side-nav>
        <div class="col-10">

            <h1>{{ $t('user.profile.settings')}}</h1>

            <div class="row">
                <div class="col-10">
                    <b-form>
                        <b-form-group
                                :label="$t('user.profile.name')"
                                label-for="user-name">
                            <b-form-input
                                    id="user-name"
                                    type="text"
                                    v-model="form.name"
                                    disabled
                                    :label="$t('user.profile.name')"
                                    required/>
                        </b-form-group>

                        <b-form-group
                                :label="$t('user.username')"
                                label-for="user-username">
                            <b-form-input
                                    id="user-username"
                                    type="text"
                                    disabled
                                    v-model="form.username"
                                    required/>
                        </b-form-group>


                    </b-form>
                </div>
                <div class="col-2">
                    <b-img :src="form.avatar" fluid :alt="$t('user.profile.avatar')" v-if="form"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import SideNav from '../../components/profile/SideNav';

    export default {
        data() {
            return {
                form: {}
            }
        },
        components: {
            SideNav
        },
        mounted() {
            let self = this;
            axios.get(config.apiUrl + '/users/' + window.config.username)
                .then(response => {
                    self.form = response.data.data;
                });
        }
    }
</script>
