import {Event} from './event';

export class Production {

    constructor(production) {
        this.production = production;
        this.events = [];
    }

    getUid() {
        return _.get(this.production, 'uid', null);
    }
    getTitle() {
        return _.get(this.production, 'title', null);
    }

    loaded() {
        return !! this.getUid();
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
        return _.get(this.production, 'description', null);
    }

    getOrganizations() {
        return this.production.organizations;
    }

    hasEvents() {
        if (!this.production) {
            return false;
        }
        return this.loadEvents().events.length > 0;
    }

    loadEvents() {
        if (this.events.length === 0 && this.production !== null && this.production.hasOwnProperty('events') && this.production.events.length > 0) {
            for (let i in this.production.events) {
                this.events.push(new Event(this.production.events[i], this));
            }
        }
        return this;
    }
    getEvents() {
        if (!this.production){
            return null;
        }

        return this.loadEvents().events;
    }
}

