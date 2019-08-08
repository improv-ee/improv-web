export class Organization {

    constructor(organization) {
        this.organization = organization;
    }

    getName() {
        return _.get(this.organization, 'name', null);
    }

    getDescription() {
        return _.get(this.organization, 'description', null);
    }

    getEmail() {
        return _.get(this.organization, 'email', null);
    }

    getHomepageUrl(pretty = false) {
        let url = _.get(this.organization, 'urls.homepage', null);
        return pretty ? Organization.getHumanUrl(url) : url;
    }

    /**
     * Return an URL for display to humans. Strip technical things
     *
     * @param url
     * @returns {*}
     */
    static getHumanUrl(url) {
        if (!url) {
            return url;
        }
        let urlObject = new URL(url);

        if (!urlObject.hostname) {
            return url;
        }

        return urlObject.hostname.replace(/^www\./, '');
    }

    getFacebookUrl(pretty = false) {
        let url = _.get(this.organization, 'urls.facebook', null);

        return pretty ? Organization.getHumanUrl(url) : url;
    }

    hasHeaderImg() {
        return !!_.get(this.organization, 'images.header.urls.original');
    }

    getHeaderImgUrl() {
        if (!this.hasHeaderImg()) {
            return null;
        }
        return _.get(this.organization, 'images.header.urls.original');
    }
}

