export class Event {
    constructor(event) {
        this.event = event;
    }

    getTitle() {

        if (this.event.title !== null) {
            return this.event.title;
        }

        return this.production.title;
    }

}