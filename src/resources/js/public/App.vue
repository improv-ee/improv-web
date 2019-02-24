<template>
    <div>
        <vue-progress-bar></vue-progress-bar>
        <notifications group="app" position="top center"/>


        <b-navbar toggleable="md"  id="top-nav" type="dark" variant="primary">

            <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>

            <b-collapse is-nav id="nav_collapse">

                <b-navbar-nav>
                    <b-nav-item exact :to="{ name: 'home' }">{{ $t("nav.schedule") }}</b-nav-item>
                    <b-nav-item exact :to="{ name: 'organizations' }">{{ $t("nav.organizations") }}</b-nav-item>
                    <b-nav-item href="https://pooltund.improv.ee">{{ $t("nav.podcast") }}</b-nav-item>
                </b-navbar-nav>
            </b-collapse>
        </b-navbar>
        <router-view></router-view>

        <BottomNav></BottomNav>
    </div>
</template>

<script>
    import BottomNav from '../components/BottomNav';
    import { progress } from '../mixins/progress';

    export default {
        components: {
            BottomNav
        },
        metaInfo: {
            titleTemplate: '%s - Improvision'
        },
        mixins: [progress]
    }
</script>
