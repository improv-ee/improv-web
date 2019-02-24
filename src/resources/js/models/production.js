export class Production {

    constructor(production) {
        this.production = production;
    }

    getTitle() {

        if (!this.production.hasOwnProperty('title') || this.production.title === null) {
            return null;
        }

        return this.production.title;
    }

    hasHeaderImg() {
        return this.production.hasOwnProperty('images') && this.production.hasOwnProperty('header');
    }

    getHeaderImgUrl() {
        if (!this.hasHeaderImg()) {
            return null;
        }
        return this.production.images.header.urls.original;
    }

    getExcerpt() {
        if (!this.production.hasOwnProperty('excerpt')) {
            return null;
        }
        return this.production.excerpt;
    }

    getDescription() {
        if (!this.production.hasOwnProperty('description')) {
            return null;
        }
        return this.production.description;
    }

    hasEvents() {
        return this.production.hasOwnProperty('events') && this.production.events.length > 0;
    }

    getEvents() {
        return this.production.events;
    }
}

