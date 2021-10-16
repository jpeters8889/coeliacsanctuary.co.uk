import Vue from 'vue';

const RegisterForm = () => import('~/Members/Register/RegisterForm' /* webpackChunkName: "chunk-register-form" */);
const OrderCompleteCreateAccount = () => import('~/Members/Register/OrderCompleteCta' /* webpackChunkName: "chunk-order-complete-create-account" */);

Vue.component('MembersRegisterOrderCompleteCta', OrderCompleteCreateAccount);
Vue.component('MemberRegisterForm', RegisterForm);
