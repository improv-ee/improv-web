<template>
    <div class="row">
        <div class="col-sm">
            <h2>{{ $t('nav.privacy') }}</h2>

            <p class="lead">Effective date: Feb 08 2019</p>

            <p>Improvision ("us", "we") operates this website (<code>improvision.eu</code>).</p>

            <h3>What we know about you</h3>

            <p>If you register an account with Improvision, we’ll have access to your e-mail address and any additional
                personal information you choose to provide us.</p>

            <p>If you browse Improvision.eu, with or without a login, we know for a limited time that a user at your IP
                address has visited pages on the site.
            We collect data on what pages you browse and how you behave on our site to do analytics, with the sole
                purpose of improving our service.</p>


            <h3>Purpose of collecting data</h3>

            <p>We collect your personal data such as your name and e-mail for the purposes of providing you an account
                in our website.
                We collect information about shows, groups, events and improv from you for the purposes of providing
                this website's core service - sharing improv information.</p>

            <p>We will not share information you provide us with third parties for monetary gain.</p>

            <h3>When and how we contact you</h3>

            <p>We send you e-mails to notify you of events taking place within our service, such as a you being invited
                to yoin an organization. We also send you e-mails to notify you
                of important account-related activities, such as password resets.</p>

            <p>We may occasionally send you an email that you did not request, if we believe this is important for you
                in order to use our service. We send you promotional newsletters only if you opt in to them and offer an
                opt-out.</p>

            <h3>Security</h3>

            <p>
                We do our best to secure the data you provide us. This involves using industry best security practices
                such as encryption, strong passwords and principle of least access.
                We are not a large organization and cannot guarantee the absolute security of your data. Additionally,
                you are responsible for your personal account security
                by using a strong, secure and unique password.
            </p>

            <h3>Logging and log retention</h3>

            <p>In order to understand traffic to our sites and diagnose technical problems, we log individual web
                requests. These logs include time of request, individual IP address, referer, and user agent strings.
                Such logs will be deleted after a certain amount of time, up to one year.</p>

            <p>Except in the case of malicious traffic, we will not share log data with any third party, unless
                compelled by legal process to do so.</p>

            <h3>Analytics</h3>

            Our analytics software to help keep track of how many unique visitors we’re getting, where they come from,
            and how they navigate our site, unless you’re browsing with Do Not Track enabled. We use this information to
            inform site improvements.
            Google Universal Analytics is a service hosted on Google’s servers, and is our primary analytics tool. It is
            activated by a JavaScript snippet that loads on every page to send visitor behavioral information to Google.
            Improvision uses this information to understand how visitors use our site. Sometimes Improvision will run
            A/B tests, where Google Analytics will track cookies set on users to divide them into groups that get
            slightly different pages to see which perform better. Visitors who have Do Not Track enabled will not have
            any information sent to Google’s servers for use in analytics.

            We do our best to serve all content securely over HTTPS.

            <h3>Your rights</h3>

            <p>As a registrered user in our service, you have the following rights:</p>

            <ul>
                <li>You can request a copy of your personal data that we hold from us. You can also ask us to modify or delete your personal data</li>
                <li>You can request us to not send any promotional material to you via electronic means</li>
                <li>You can request us to close your account and remove any personal information we hold about you</li>
            </ul>

            <p>In order to exercise these rights, please e-mail us from the e-mail address you used to sign up for an account.</p>

            <h3>Changes to this policy</h3>

            <p>We may update this policy from time to time without notifying you in advance. This policy is a public
                document visible on our GitHub page and changes will be posted and trackable there
                before going into effect. You are advised to monitor this page or GitHub file periodically.</p>


            <h3>Questions?</h3>
            <p>If you have any questions or feedback regarding this privacy policy, including if you feel Improvision
                or someone within the Improvision community has violated it, or if you are concerned about Improvision’s
                general philosophy
                toward user privacy, please contact us at <code class="reversed">ue.noisivorpmi@troppus</code>.</p>

        </div>
    </div>

</template>
<script>
    export default {
        metaInfo() {
            return {
                title: this.$t('nav.privacy')
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