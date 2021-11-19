import Vue from 'vue';
import PopupCta from '~/Global/UI/PopupCta';
import NewsletterSignup from '~/Global/UI/NewsletterSignup';
import GoogleAd from '~/Global/UI/GoogleAd';

const LinkButton = () => import('~/Global/UI/LinkButton' /* webpackChunkName: "chunk-link-button" */);
const NumberCountUp = () => import('~/Global/UI/NumberCountUp' /* webpackChunkName: "chunk-number-count" */);
const Accordion = () => import('~/Global/UI/Accordion' /* webpackChunkName: "chunk-accordion" */);
const RecipeImage = () => import('~/Global/UI/RecipeImage' /* webpackChunkName: "chunk-recipe-image" */);
const Stars = () => import('~/Global/UI/Stars' /* webpackChunkName: "chunk-stars" */);

Vue.component('GlobalUiAccordion', Accordion);
Vue.component('GlobalUiGoogleAd', GoogleAd);
Vue.component('GlobalUiLinkButton', LinkButton);
Vue.component('GlobalUiNumberCounter', NumberCountUp);
Vue.component('GlobalUiPopupCta', PopupCta);
Vue.component('GlobalUiRecipeImage', RecipeImage);
Vue.component('GlobalUiStars', Stars);
Vue.component('GlobalUiNewsletterSignup', NewsletterSignup);
