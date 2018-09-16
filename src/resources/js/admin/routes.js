import Home from './views/Home'
import PageNotFound from '../views/PageNotFound'
import ProductionsList from './views/productions/List'
import ProductionDetails from './views/productions/Details'
import ProductionEdit from './views/productions/Edit'
import EventDetails from './views/events/Details'
import EventEdit from './views/events/Edit'
import ProfileSettings from './views/profile/Settings'
import OrganizationsList from './views/organizations/List'
import OrganizationDetails from './views/organizations/Details'
import OrganizationEdit from './views/organizations/Edit'

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
    },
    { path: "*", component: PageNotFound }
];