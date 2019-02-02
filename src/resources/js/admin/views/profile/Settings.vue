<template>
    <div>
        <div class="row">
            <div class="col-12">
                <h1>{{ $t('user.profile.settings')}}</h1>

                <h2>{{ $t('user.profile.api_tokens') }}</h2>
                <passport-personal-access-tokens></passport-personal-access-tokens>

            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <Invite></Invite>
            </div>
        </div>
    </div>
</template>

<script>
    import PassportPersonalAccessTokens from '../../components/passport/PersonalAccessTokens';
    import Invite from '../../components/profile/Invite';

    export default {
        components: {
            PassportPersonalAccessTokens,
            Invite
        }
    }
</script>
