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
          <b-nav-item href="https://pooltund.improv.ee">
            {{ $t("nav.podcast") }}
          </b-nav-item>
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

export default {
    components: {
        BottomNav,
        NavLanguageSwitcher
    },
    mixins: [progress],
    metaInfo: {
        titleTemplate: '%s - Improv.ee'
    }
};
</script>
