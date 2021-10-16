import Vue from 'vue';

const CoeliacIcon = () => import('~/Global/Layout/CoeliacIcon' /* webpackChunkName: "preload-coeliac-icon" */);
const MobileNav = () => import('~/Global/Layout/MobileNav' /* webpackChunkName: "preload-mobile-nav" */);
const TopBar = () => import('~/Global/Layout/TopBar' /* webpackChunkName: "preload-top-bar" */);
const FooterNewsletter = () => import('~/Global/Layout/FooterNewsletter' /* webpackChunkName: "chunk-footer-newsletter" */);
const Breadcrumbs = () => import('~/Global/Layout/Breadcrumbs' /* webpackChunkName: "chunk-breadcrumbs" */);
const FullPageLoader = () => import('~/Global/Layout/FullPageLoader' /* webpackChunkName: "chunk-page-loader" */);
const Announcement = () => import('~/Global/Layout/Announcement' /* webpackChunkName: "chunk-announcements" */);

Vue.component('GlobalLayoutAnnouncement', Announcement);
Vue.component('GlobalLayoutBreadcrumbs', Breadcrumbs);
Vue.component('GlobalLayoutCoeliacIcon', CoeliacIcon);
Vue.component('GlobalLayoutFooterNewsletter', FooterNewsletter);
Vue.component('GlobalLayoutFullPageLoader', FullPageLoader);
Vue.component('GlobalLayoutMobileNav', MobileNav);
Vue.component('GlobalLayoutTopBar', TopBar);
