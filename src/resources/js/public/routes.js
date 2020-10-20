import EventSchedule from './views/EventSchedule.vue';
import EventDetails from './views/EventDetails.vue';
import PageNotFound from '../views/PageNotFound';
import OrganizationsList from './views/organizations/List';
import OrganizationDetails from './views/organizations/Details';
import Contact from './views/Contact';
import MarkdownView from '../components/MarkdownView';
import ProductionDetails from './views/productions/Details';
import GigsList from './views/gigs/List';

export function getRoutes(i18n){
    return [
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
            path: '/productions/:uid',
            name: 'productions',
            component: ProductionDetails,
        },
        {
            path: '/organizations',
            name: 'organizations',
            component: OrganizationsList,
        },
        {
            path: '/gigs',
            name: 'gigs',
            component: GigsList,
        },
        {
            path: '/organizations/:uid',
            name: 'organization.details',
            component: OrganizationDetails,
        },
        {
            path: '/contact',
            name: 'contact',
            component: Contact
        },
        {
            path: '/privacy',
            name: 'privacy',
            component: MarkdownView,
            props: {
                title: i18n.t('nav.privacy'),
                view: 'privacy.md'
            }
        },
        {
            path: '/terms',
            name: 'terms',
            component: MarkdownView,
            props: {
                title: i18n.t('nav.terms'),
                view: 'terms.md'
            }
        },
        {
            path: '/improv/about',
            name: 'aboutImprov',
            component: MarkdownView,
            props: {
                title: i18n.t('nav.what_is_improv'),
                view: 'improv/about.md'
            }
        },
        {
            path: '/improv/history',
            name: 'improvHistory',
            component: MarkdownView,
            props: {
                title: i18n.t('nav.improv_history'),
                view: 'improv/history.md'
            }
        },
        { path: '*', component: PageNotFound }
    ];
}
