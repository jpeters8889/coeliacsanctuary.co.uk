import Vue from "vue";

const LinkButton = () => import("~/Global/UI/LinkButton" /* webpackChunkName: "chunk-link-button" */);
const NumberCountUp = () => import("~/Global/UI/NumberCountUp" /* webpackChunkName: "chunk-number-count" */);
const Accordion = () => import("~/Global/UI/Accordion" /* webpackChunkName: "chunk-accordion" */);
const NewsletterSignup = () => import("~/Global/UI/NewsletterSignup" /* webpackChunkName: "chunk-newsletter-signup" */);
const RecipeImage = () => import("~/Global/UI/RecipeImage" /* webpackChunkName: "chunk-recipe-image" */);
const Tabs = () => import("~/Global/UI/Tabs" /* webpackChunkName: "chunk-tabs" */);
const Tab = () => import("~/Global/UI/Tab" /* webpackChunkName: "chunk-tab" */);
const Stars = () => import("~/Global/UI/Stars" /* webpackChunkName: "chunk-stars" */);
const PopupCta = () => import("~/Global/UI/PopupCta" /* webpackChunkName: "preload-popup-cta" */);
const GoogleAd = () => import('~/Global/UI/GoogleAd' /* webpackChunkName: "preload-google-ad" */);

Vue.component('global-ui-accordion', Accordion);
Vue.component('global-ui-google-ad', GoogleAd);
Vue.component('global-ui-link-button', LinkButton);
Vue.component('global-ui-number-counter', NumberCountUp);
Vue.component('global-ui-popup-cta', PopupCta);
Vue.component('global-ui-recipe-image', RecipeImage);
Vue.component('global-ui-stars', Stars);
Vue.component('global-ui-tab', Tab);
Vue.component('global-ui-tabs', Tabs);
Vue.component('global-ui-newsletter-signup', NewsletterSignup);
