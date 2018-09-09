<template>
<div>
        <nav id="top-nav" class="nav nav-pills flex-column flex-sm-row">
            <router-link :to="{ name: 'home' }" class="flex-sm-fill nav-link text-sm-center p-2 text-muted">{{ $t("nav.schedule") }}</router-link>
            <a class="flex-sm-fill nav-link text-sm-center p-2 text-muted" href="#">Õppimine</a>
            <a class="flex-sm-fill nav-link text-sm-center p-2 text-muted" href="#">Trupid</a>
            <a class="flex-sm-fill nav-link text-sm-center p-2 text-muted" href="#">Kutsu esinema</a>
            <a class="flex-sm-fill nav-link text-sm-center p-2 text-muted" href="https://pooltund.improv.ee">{{ $t("nav.podcast") }}</a>
            <router-link :to="{ name: 'newsletter' }" class="flex-sm-fill nav-link text-sm-center p-2 text-muted">{{ $t("nav.newsletter") }}</router-link>
        </nav>

    <router-view></router-view>
</div>
</template>

<script>
    export default {
    }
</script>