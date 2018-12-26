<template>

    <div>
        <notifications group="app" position="top center" width="50%" duration="5000"/>

        <b-navbar toggleable="md" id="top-nav" type="dark" variant="default">

            <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>

            <b-collapse is-nav id="nav_collapse">

                <b-navbar-nav>
                    <b-nav-item exact to="/">{{ $t("nav.home") }}</b-nav-item>
                    <b-nav-item :to="{ name: 'productions' }">{{ $t("nav.productions") }}</b-nav-item>
                    <b-nav-item :to="{ name: 'organizations' }">{{ $t("nav.organizations") }}
                    </b-nav-item>
                </b-navbar-nav>
            </b-collapse>
        </b-navbar>

        <div class="row">
            <div class="col-12 admin-content">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>
