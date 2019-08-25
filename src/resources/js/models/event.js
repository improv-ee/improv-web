export class Event {
    constructor(event, production) {
        this.event = event;
        this.production = production;
    }

    getUid() {
        return _.get(this.event, 'uid');
    }

    getDescription() {
        if (this.event.description !== null){
            return this.event.description;
        }
        return this.production.description;
    }
    getTitle() {

        if (this.event.title !== null) {
            return this.event.title;
        }

        return this.production.title;
    }

    setProduction(production) {
        this.production = production;
        return this;
    }

    getHeaderImgUrl() {
        if (this.event.images && this.event.images.header && this.event.images.header.urls) {
            return this.event.images.header.urls.original;
        }
        return this.production.getHeaderImgUrl() || '/img/production/default-header.jpg';
    }

}