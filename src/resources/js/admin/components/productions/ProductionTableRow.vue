<template>

   <tr @click="openProduction(production.slug)">
       <td>{{ production.title }}</td>
       <td>{{ production.events.length }}</td>
   </tr>
</template>

<script>

    export default {
        props: ['production'],
        methods: {
            openProduction(slug) {
                this.$router.push({ name: 'production.details', params: { slug: slug }})
            }
        }

    }
</script>
