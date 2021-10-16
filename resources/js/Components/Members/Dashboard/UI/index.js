import Vue from 'vue';

const DashboardNavigation = () => import('~/Members/Dashboard/UI/Navigation' /* webpackChunkName: "chunk-member-dashboard" */);

Vue.component('MemberDashboardUiNavigation', DashboardNavigation);
