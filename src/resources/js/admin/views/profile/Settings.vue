<template>

    <div class="row">
        <div class="col-12">
            <h1>{{ $t('user.profile.settings')}}</h1>

            <h2>{{ $t('user.profile.api_tokens') }}</h2>
            <passport-personal-access-tokens></passport-personal-access-tokens>

        </div>
    </div>

</template>

<script>
    import PassportPersonalAccessTokens from '../../components/passport/PersonalAccessTokens';

    export default {
        components: {
            PassportPersonalAccessTokens
        },
    }
</script>
