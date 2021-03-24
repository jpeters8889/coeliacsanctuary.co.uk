import Vue from "vue";

const VerifyEmailResendTrigger = () => import('~/Members/UI/VerifyEmailResendTrigger' /* webpackChunkName: "chunk-resend-verify-email" */)

Vue.component('member-ui-verify-email-resend-trigger', VerifyEmailResendTrigger);
