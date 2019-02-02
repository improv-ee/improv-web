<template>
    <div class="row">
        <div class="col-sm">
            <h2>{{ $t('contact.greeting') }}</h2>
            <p class="lead">{{ $t('contact.intro') }}</p>
            <p>{{ $t('contact.platform_description') }}</p>
            <p v-html="$t('contact.contact', {email: contactEmail})"></p>
        </div>
    </div>

</template>

<script>

    export default {
        data() {
            return {
                // Spambot scraper protection, reverse the e-mail
                contactEmail: '<span class="reversed">ue.noisivorpmi@troppus</span>'
            }
        }
    }
</script>

<style>
    .reversed {
        unicode-bidi:bidi-override;
        direction:rtl;
    }
</style>