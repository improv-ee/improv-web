import EventSchedule from './views/EventSchedule.vue'
import EventDetails from './views/EventDetails.vue'
import Newsletter from './views/Newsletter.vue'

export default [
    {
        path: '/',
        name: 'home',
        component: EventSchedule
    },
    {
        path: '/events/:uid',
        name: 'events',
        component: EventDetails,
    },
    {
        path: '/newsletter',
        name: 'newsletter',
        component: Newsletter,
    },
];