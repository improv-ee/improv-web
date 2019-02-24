<template>
    <div class="row">
        <side-nav></side-nav>
        <div class="col-10">

            <h2>{{ $t('user.profile.api_tokens') }}</h2>
            <passport-personal-access-tokens></passport-personal-access-tokens>

        </div>
    </div>
</template>

<script>
    import PassportPersonalAccessTokens from '../../components/passport/PersonalAccessTokens';
    import SideNav from '../../components/profile/SideNav';

    export default {
        components: {
            PassportPersonalAccessTokens,
            SideNav
        }
    }
</script>
