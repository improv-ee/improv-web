<template>
  <tr
    :class="{ 'row-muted': !production.hasUpcomingEvents }"
    @click="openProduction(production.uid)">
    <td>{{ production.title }}</td>
    <td
      v-if="!production.hasUpcomingEvents"
      :title="$t('production.no_upcoming_events_description')">
      {{ production.events.length }} <i class="fas fa-flag-checkered" />
    </td>
    <td v-else>
      {{ production.events.length }}
    </td>
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
