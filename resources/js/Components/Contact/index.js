import Vue from 'vue';

const ContactTrigger = () => import('~/Contact/Trigger' /* webpackChunkName: "chunk-contact-trigger" */);

Vue.component('ContactTrigger', ContactTrigger);
