import Vue from 'vue';

const CoeliacIcon = () => import("~/Global/Layout/CoeliacIcon" /* webpackChunkName: "preload-coeliac-icon" */);
const MobileNav = () => import("~/Global/Layout/MobileNav" /* webpackChunkName: "preload-mobile-nav" */);
const TopBar = () => import("~/Global/Layout/TopBar" /* webpackChunkName: "preload-top-bar" */);
const FooterNewsletter = () => import("~/Global/Layout/FooterNewsletter" /* webpackChunkName: "chunk-footer-newsletter" */);
const Breadcrumbs = () => import("~/Global/Layout/Breadcrumbs" /* webpackChunkName: "chunk-breadcrumbs" */);
const FullPageLoader = () => import("~/Global/Layout/FullPageLoader" /* webpackChunkName: "chunk-page-loader" */);
const Announcement = () => import("~/Global/Layout/Announcement" /* webpackChunkName: "chunk-announcements" */);

Vue.component('global-layout-announcement', Announcement);
Vue.component('global-layout-breadcrumbs', Breadcrumbs);
Vue.component('global-layout-coeliac-icon', CoeliacIcon);
Vue.component('global-layout-footer-newsletter', FooterNewsletter);
Vue.component('global-layout-full-page-loader', FullPageLoader);
Vue.component('global-layout-mobile-nav', MobileNav);
Vue.component('global-layout-top-bar', TopBar);
