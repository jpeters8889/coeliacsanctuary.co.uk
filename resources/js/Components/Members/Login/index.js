import Vue from "vue";

const LoginForm = () => import('~/Members/Login/LoginForm' /* webpackChunkName: "chunk-login-form" */)
const LoginTrigger = () => import('~/Members/Login/LoginTrigger' /* webpackChunkName: "preload-login-trigger" */)

Vue.component('member-login-form', LoginForm);
Vue.component('member-login-trigger', LoginTrigger);
