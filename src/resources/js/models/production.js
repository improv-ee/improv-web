export class Production {

    constructor(production) {
        this.production = production;
    }

    getUid() {
        return _.get(this.production, 'uid', null);
    }
    getTitle() {
        return _.get(this.production, 'title', null);
    }

    hasHeaderImg() {
        return !!_.get(this.production, 'images.header');
    }

    getHeaderImgUrl() {
        if (!this.hasHeaderImg()) {
            return null;
        }
        return _.get(this.production, 'images.header.urls.original');
    }

    getExcerpt() {
        return _.get(this.production, 'excerpt', null);
    }

    getDescription() {
        return _.get(this.production, 'excerpt', null);
    }

    getOrganizations() {
        return this.production.organizations;
    }

    hasEvents() {
        return this.production.hasOwnProperty('events') && this.production.events.length > 0;
    }

    getEvents() {
        if (!this.production){
            return null;
        }
        return this.production.events;
    }
}

