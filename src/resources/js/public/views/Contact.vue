<template>
  <div class="row">
    <div class="col-sm">
      <h2>{{ $t('contact.greeting') }}</h2>
      <p class="lead">
        {{ $t('contact.intro') }}
      </p>
      <p>{{ $t('contact.platform_description') }}</p>
      <!-- eslint-disable-next-line vue/no-v-html -->
      <p v-html="$t('contact.contact', {email: contactEmail})" />
    </div>
  </div>
</template>

<script>

export default {
    data() {
        return {
            // Spambot scraper protection, reverse the e-mail
            contactEmail: '<span class="reversed">ee.vorpmi@troppus</span>'
        };
    }
};
</script>
