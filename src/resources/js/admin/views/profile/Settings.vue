<template>

    <div class="row">
        <div class="col-6 offset-3">

            <passport-clients></passport-clients>
            <passport-authorized-clients></passport-authorized-clients>
            <passport-personal-access-tokens></passport-personal-access-tokens>

        </div>
    </div>

</template>

<script>
    import PassportAuthorizedClients from '../../components/passport/AuthorizedClients';
    import PassportClients from '../../components/passport/Clients';
    import PassportPersonalAccessTokens from '../../components/passport/PersonalAccessTokens';

    export default {
        components: {
            PassportAuthorizedClients,
            PassportClients,
            PassportPersonalAccessTokens
        },
    }
</script>
