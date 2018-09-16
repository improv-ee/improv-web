import Home from './views/Home.vue'
import ProductionsList from './views/productions/List.vue'
import ProductionDetails from './views/productions/Details.vue'
import ProductionEdit from './views/productions/Edit.vue'
import EventDetails from './views/events/Details.vue'
import EventEdit from './views/events/Edit.vue'
import ProfileSettings from './views/profile/Settings.vue'
import OrganizationsList from './views/organizations/List.vue'
import OrganizationDetails from './views/organizations/Details.vue'
import OrganizationEdit from './views/organizations/Edit.vue'

export default [
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/productions',
        name: 'productions',
        component: ProductionsList,
    },
    {
        path: '/events/:uid',
        name: 'event.details',
        component: EventDetails,
    },
    {
        path: '/events/:uid/edit',
        name: 'event.edit',
        component: EventEdit,
    },
    {
        path: '/productions/:slug',
        name: 'production.details',
        component: ProductionDetails,
    }, {
        path: '/productions/:slug/edit',
        name: 'production.edit',
        component: ProductionEdit,
    },
    {
        path: '/profile/settings',
        name: 'profile.settings',
        component: ProfileSettings,
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
        path: '/organizations/:slug/edit',
        name: 'organization.edit',
        component: OrganizationEdit,
    }
];