<template>
    <div class="row">
        <side-nav></side-nav>
        <div class="col-10">
            <h2>{{ $t('user.profile.api_tokens') }}</h2>
            <p v-html="$t('user.settings.api.tokens_intro', {apiDoc: apiDoc})"></p>
            <passport-personal-access-tokens></passport-personal-access-tokens>

        </div>
    </div>
</template>

<script>
    import PassportPersonalAccessTokens from '../../components/passport/PersonalAccessTokens';
    import SideNav from '../../components/profile/SideNav';

    export default {
        data(){
            return {
                apiDoc: '<a href="https://docs.improvision.eu" target="_blank">docs.improvision.eu</a>'
            }
        },
        components: {
            PassportPersonalAccessTokens,
            SideNav
        }
    }
</script>
