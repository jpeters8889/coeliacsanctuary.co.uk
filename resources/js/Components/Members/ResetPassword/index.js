import Vue from 'vue';

const ResetPasswordForm = () => import('~/Members/ResetPassword/ResetPasswordForm' /* webpackChunkName: "chunk-forgot-password-form" */);

Vue.component('MemberResetPasswordForm', ResetPasswordForm);
