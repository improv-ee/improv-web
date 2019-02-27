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
		if (pretty){
			return null;
		}
		return _.get(this.organization, 'urls.homepage', null);
	}

	getFacebookUrl(pretty = false) {
		if (pretty){
			return null;
		}
		return _.get(this.organization, 'urls.facebook', null);
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

