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

        // List of legacy routes
        // These are routes handled by Laravel, ie the views are Blade HTML rendering
        // Vue.js is still loaded on these pages tho, in order to not 404 them, declare them as empty component routes
        // Longer term plan is to extract these routes out of Laravel and into Vue
        {path: '/login'},
        {path: '/register'},
        {path: '/password/reset/:token'},
        {path: '/oauth/scopes'},
        {path: '/oauth/personal-access-tokens'},
        {path: '/email/verify'},
        {path: '/email/verify/:token'},
        {
            path: '*',
            component: PageNotFound,
            beforeEnter() {
                // Redirect to a non-Vue 404 page (responded to by Laravel)
                // This allows us to respond with a 404 Status Code, mainly for SEO
                // eslint-disable-next-line no-console
                console.error('Page not found');
                window.location = '/not-found';
            }
        }
    ];
}
