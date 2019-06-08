<template>
  <tr @click="openProduction(production.uid)">
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
        openProduction(uid) {
            this.$router.push({name: 'production.details', params: {uid: uid}});
        }
    }

};
</script>
