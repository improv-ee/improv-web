<template>
  <div>
    <vue-progress-bar />
    <notifications
      group="app"
      position="top center" />


    <b-navbar
      id="top-nav"
      toggleable="md"
      type="dark"
      variant="primary">
      <b-navbar-toggle target="nav_collapse" />

      <b-collapse
        id="nav_collapse"
        is-nav>
        <b-navbar-nav>
          <b-nav-item
            exact
            :to="{ name: 'home' }">
            {{ $t("nav.schedule") }}
          </b-nav-item>
          <b-nav-item
            exact
            :to="{ name: 'organizations' }">
            {{ $t("nav.organizations") }}
          </b-nav-item>
          <b-nav-item
            exact
            :to="{ name: 'gigs' }">
            {{ $t("nav.gigs") }}
          </b-nav-item>
          <b-nav-item-dropdown
            v-if="countryLinks.hasOwnProperty(currentLanguage)"
            :text="$t('nav.local_improv')">
            <b-dropdown-item
              v-for="item in countryLinks[currentLanguage]"
              :key="item.link"
              :target="item.target || '_self'"
              :href="item.link">
              <i
                v-if="item.icon"
                :class="item.icon" />
              {{ item.text }}
            </b-dropdown-item>
          </b-nav-item-dropdown>
          <b-nav-item-dropdown
            :text="$t('nav.about_improv')">
            <b-dropdown-item
              :to="{ name: 'aboutImprov'}">
              {{ $t('nav.what_is_improv') }}
            </b-dropdown-item>
            <b-dropdown-item
              :to="{ name: 'improvHistory'}">
              {{ $t('nav.improv_history') }}
            </b-dropdown-item>
          </b-nav-item-dropdown>
        </b-navbar-nav>

        <nav-language-switcher />
      </b-collapse>
    </b-navbar>
    <router-view />

    <BottomNav />
  </div>
</template>

<script>
import BottomNav from '../components/BottomNav';
import { progress } from '../mixins/progress';
import NavLanguageSwitcher from '../components/NavLanguageSwitcher';
import countryLinks from './country-links';

export default {
    components: {
        BottomNav,
        NavLanguageSwitcher
    },
    mixins: [progress],
    data() {
        return {
            countryLinks: countryLinks
        };
    },
    computed: {
        currentLanguage: function () {
            return window.config.languages.current;
        }
    },
    metaInfo: {
        titleTemplate: '%s - Improv.ee'
    }
};
</script>
