export class Event {
    constructor(event, production) {
        this.event = event;
        this.production = production;
    }

    getProduction() {
        return this.production;
    }

    getUid() {
        return _.get(this.event, 'uid');
    }

    getProductionUid() {
        return _.get(this.event, 'production.uid');
    }

    getDescription() {
        if (this.event.description !== null){
            return this.event.description;
        }
        return this.production.getDescription();
    }

    getStartTimeHuman() {
        return moment(this.event.times.start).format('Do MMMM HH:mm');
    }

    getStartTime() {
        return _.get(this.event,'times.start');
    }

    getEndTime() {
        return _.get(this.event,'times.end');
    }

    getPlace() {
        return this.event.place;
    }

    hasPlace() {
        return !!_.get(this.event,'place.address');
    }

    getEndTimeHuman() {
        return moment(this.event.times.end).format('HH:mm');
    }

    hasHeaderImg() {
        return !!_.get(this.event, 'images.header');
    }

    getTitle() {

        if (this.event.title !== null) {
            return this.event.title;
        }

        return this.production.getTitle();
    }

    setProduction(production) {
        this.production = production;
        return this;
    }

    getHeaderImgUrl() {
        if (this.event && this.event.images && this.event.images.header && this.event.images.header.urls) {
            return this.event.images.header.urls.original;
        }
        return this.production.getHeaderImgUrl() || '/img/production/default-header.jpg';
    }

}