import Vue from 'vue';

const LinkButton = () => import('~/Global/UI/LinkButton' /* webpackChunkName: "chunk-link-button" */);
const NumberCountUp = () => import('~/Global/UI/NumberCountUp' /* webpackChunkName: "chunk-number-count" */);
const Accordion = () => import('~/Global/UI/Accordion' /* webpackChunkName: "chunk-accordion" */);
const NewsletterSignup = () => import('~/Global/UI/NewsletterSignup' /* webpackChunkName: "chunk-newsletter-signup" */);
const RecipeImage = () => import('~/Global/UI/RecipeImage' /* webpackChunkName: "chunk-recipe-image" */);
const Stars = () => import('~/Global/UI/Stars' /* webpackChunkName: "chunk-stars" */);
const PopupCta = () => import('~/Global/UI/PopupCta' /* webpackChunkName: "preload-popup-cta" */);
const GoogleAd = () => import('~/Global/UI/GoogleAd' /* webpackChunkName: "preload-google-ad" */);

Vue.component('GlobalUiAccordion', Accordion);
Vue.component('GlobalUiGoogleAd', GoogleAd);
Vue.component('GlobalUiLinkButton', LinkButton);
Vue.component('GlobalUiNumberCounter', NumberCountUp);
Vue.component('GlobalUiPopupCta', PopupCta);
Vue.component('GlobalUiRecipeImage', RecipeImage);
Vue.component('GlobalUiStars', Stars);
Vue.component('GlobalUiNewsletterSignup', NewsletterSignup);
