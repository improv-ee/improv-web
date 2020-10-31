export class Organization {

    constructor(organization) {
        this.organization = organization;
    }

    getName() {
        return _.get(this.organization, 'name', null);
    }

    getUid() {
        return _.get(this.organization, 'uid', null);
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

    hasHomepage(){
        return !! this.getHomepageUrl();
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

    hasHeaderImgPlaceholder() {
        return !!_.get(this.organization, 'images.header.placeholder');
    }

    getHeaderImgPlaceholder() {

        if (this.hasHeaderImgPlaceholder()) {
            return this.organization.images.header.placeholder;
        }
        return config.webUrl + '/img/production/default-header.jpg';
    }

    getHeaderImgSrcset() {
        if (this.hasHeaderImg()) {
            return this.organization.images.header.urls.srcset;
        }
        return null;
    }

    getHeaderImgUrl() {
        if (!this.hasHeaderImg()) {
            return config.webUrl + '/img/production/default-header.jpg';
        }
        return _.get(this.organization, 'images.header.urls.original');
    }
}

