<template>
  <tr @click="openProduction(production.slug)">
    <td>{{ production.title }}</td>
    <td>{{ production.events.length }}</td>
  </tr>
</template>

<script>

export default {
    props: {
        production: {
            type: Object, default: function () {
                return {};
            }
        }
    },
    methods: {
        openProduction(slug) {
            this.$router.push({name: 'production.details', params: {slug: slug}});
        }
    }

};
</script>
