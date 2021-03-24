import Vue from "vue";

const DashboardUserDetails = () => import('~/Members/Dashboard/Modals/UserDetails' /* webpackChunkName: "chunk-dashboard-user-details" */)

Vue.component('member-dashboard-modal-user-details', DashboardUserDetails)
