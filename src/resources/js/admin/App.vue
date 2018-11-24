<template>
    <div>
        <div class="row">
            <div class="col-8 offset-2">
                <notifications group="app" position="top center"/>
            </div>
        </div>

        <div class="row">
            <div class="col-2">

                <nav class="nav bg-light flex-column">
                    <router-link exact active-class="active" to="/"
                                 class="flex-sm-fill nav-link text-sm-center p-2 text-muted">{{ $t("nav.home") }}
                    </router-link>
                    <router-link active-class="active" :to="{ name: 'productions' }"
                                 class="flex-sm-fill nav-link text-sm-center p-2 text-muted">{{ $t("nav.productions") }}
                    </router-link>
                    <router-link active-class="active" :to="{ name: 'organizations' }"
                                 class="flex-sm-fill nav-link text-sm-center p-2 text-muted">{{ $t("nav.organizations")
                        }}
                    </router-link>
                </nav>

            </div>
            <div class="col-10">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script>

    export default {}
</script>