<template>

    <div class="card mb-4 shadow-sm event-card">
                <img class="card-img-top flex-auto d-none d-lg-block" :src="production.header_img" alt="Card image cap">
            <div class="card-body align-items-start">

                <h3 class="mb-0">
                    {{ production.title }}
                </h3>
                <div class="mb-1 text-muted">Nov 12</div>
                <p class="card-text mb-auto">{{ production.excerpt }}</p>
            </div>

    </div>
</template>

<script>
    export default {
        props: ['production'],
        mounted() {
        }
    }
</script>
