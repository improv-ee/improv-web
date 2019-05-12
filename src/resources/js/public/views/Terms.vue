<template>
  <div class="row">
    <div class="col-sm">
      <h2>{{ $t('nav.terms') }}</h2>

      <p class="lead">
        Effective date: Feb 24 2019
      </p>

      <p>
        This site is brand new and we're not lawyers - so we don't yet have fancy legalese as our terms of service.
        Hence, we outline the below in laymans terms.
      </p>

      <h3>Acceptance of terms</h3>
      <p>By using <code>improv.ee</code>, you agree to all the terms on this page.</p>

      <h3>Description of service</h3>
      <p>
        <code>improv.ee</code> is a website where you can get information about improvisational theatre and events. This information is crowdsourced, meaning you
        have the opportunity to provide it. The service will sometimes break without warning.
      </p>

      <h3>Registration</h3>
      <p>
        You can use this site as a guest (unregistrered user), but you won't have access to features that registrered users have. To have access to these features,
        you need to create an account with us and comply with our terms.
      </p>

      <h3>Content</h3>
      <p>The information this site provides can change at any time and not be entirely accurate - we depend on crowdsourcing to provide up-to-date information.</p>

      <h3>Conduct</h3>
      <p>
        You agree to provide quality content that is relevant to the purpose of this site. If you post spammy content not relevant to the site, it can be removed by us.
        You are allowed to use our API to integrate with us and scrape content. You are not allowed to introduce unneeded load on our servers or try to misuse the service.
      </p>

      <h3>Third party stuff</h3>
      <p>We post links to external sites, but we are not responsible for what you find there. Click on your own risk.</p>

      <h3>Security research</h3>
      <p>
        Security research is allowed, if the researcher follows commonly accepted white-hat researcher best practices and responsible disclosure.
        Avoid intentionally harming the operation of this service and accessing non-public information of other profiles.
      </p>

      <p>Contact information for reporting found vulnerabilities is at <a href="/security.txt">/security.txt</a>.</p>

      <h3>Liability</h3>
      <p>
        We provide this service on best faith, best effort basis. We are not responsible if the service breaks or information is lost, but we do try to fix it. We are not responsible if your account gets compromised
        due to a leaked/weak password that you used. If you got information about an improv event from this site and went there, but it was boring, we won't give you your money back. If it was awesome, we won't give you money back, either.
      </p>

      <h3>Termination</h3>
      <p>You can get banned from this site and/or your account terminated. This will usually happen if you violate our terms.</p>

      <h3>Questions?</h3>
      <p>You can get in touch with us by <code class="reversed">ee.vorpmi@troppus</code>. If you don't agree with any of the terms here; or if you want to make us better, join us - Improv.ee is open source at GitHub. You can submit a pull request or otherwise help us out.</p>
    </div>
  </div>
</template>

<script>
export default {
    metaInfo() {
        return {
            title: this.$t('nav.terms')
        };
    }
};
</script>
