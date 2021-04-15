import Vue from "vue";

const ForgotPasswordForm = () => import('~/Members/ForgotPassword/ForgotPasswordForm' /* webpackChunkName: "chunk-forgot-password-form" */)

Vue.component('member-forgot-password-form', ForgotPasswordForm);
