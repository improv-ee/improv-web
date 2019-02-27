<template>
  <div class="row">
    <side-nav />
    <div class="col-10">
      <h2>{{ $t('user.profile.api_tokens') }}</h2>
      <!-- eslint-disable-next-line vue/no-v-html -->
      <p v-html="$t('user.settings.api.tokens_intro', {apiDoc: apiDoc})" />
      <passport-personal-access-tokens />
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
    },
    data(){
        return {
            apiDoc: '<a href="https://docs.improvision.eu" target="_blank">docs.improvision.eu</a>'
        };
    }
};
</script>
