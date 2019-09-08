<template>
  <b-navbar-nav
    class="ml-auto lang-selector">
    <b-nav-item-dropdown
      text="Lang"
      no-caret
      right>
      <template slot="button-content">
        <img
          :src="getFlagImageUrl(currentLanguage)"
          :alt="currentLanguage">
      </template>
      <b-dropdown-item
        v-for="lang in availableLanguages"
        :key="lang"
        :href="'/lang/' + lang">
        <img
          :src="getFlagImageUrl(lang)"
          :alt="lang">
      </b-dropdown-item>
    </b-nav-item-dropdown>
  </b-navbar-nav>
</template>

<script>

export default {
    computed: {
        availableLanguages: function () {
            return window.config.languages.supported;
        },
        currentLanguage: function () {
            return window.config.languages.current;
        }
    },
    methods: {
        getFlagImageUrl(language) {
            return '/img/i18n/' + language + '.svg';
        }
    }

};
</script>
