import EventSchedule from './views/EventSchedule.vue'
import EventDetails from './views/EventDetails.vue'
import PageNotFound from "../views/PageNotFound";
import OrganizationsList from './views/organizations/List'
import OrganizationDetails from './views/organizations/Details'
import Contact from './views/Contact';


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
        path: '/organizations',
        name: 'organizations',
        component: OrganizationsList,
    },
    {
        path: '/organizations/:slug',
        name: 'organization.details',
        component: OrganizationDetails,
    },
    {
        path: '/contact',
        name: 'contact',
        component: Contact
    },
    { path: "*", component: PageNotFound }
];