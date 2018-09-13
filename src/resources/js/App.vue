<template>
<div>
    <notifications group="app" position="top center" />
        <nav id="top-nav" class="nav flex-column flex-sm-row">
            <router-link active-class="active" exact :to="{ name: 'home' }" class="flex-sm-fill nav-link text-sm-center p-2 text-muted">{{ $t("nav.schedule") }}</router-link>
            <a class="flex-sm-fill nav-link text-sm-center p-2 text-muted" href="https://pooltund.improv.ee">{{ $t("nav.podcast") }}</a>
            <router-link active-class="active" :to="{ name: 'newsletter' }" class="flex-sm-fill nav-link text-sm-center p-2 text-muted">{{ $t("nav.newsletter") }}</router-link>
        </nav>

    <router-view></router-view>
</div>
</template>

<script>
    export default {
    }
</script>