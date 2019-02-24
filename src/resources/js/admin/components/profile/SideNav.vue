<template>
  <div class="col-2">
    <b-nav
      vertical
      class="side-nav">
      <b-nav-item :to="{ name: 'profile.settings' }">
        {{ $t("user.profile.settings") }}
      </b-nav-item>
      <b-nav-item :to="{ name: 'profile.api.tokens' }">
        {{ $t("user.profile.api_tokens") }}
      </b-nav-item>
      <b-nav-item :to="{ name: 'profile.invite' }">
        {{ $t("user.profile.invite.send_invitation") }}
      </b-nav-item>
    </b-nav>
  </div>
</template>
