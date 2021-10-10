import Vue from 'vue';

const DashboardRecentOrders = () => import('~/Members/Dashboard/Pages/RecentOrders' /* webpackChunkName: "chunk-dashboard-recent-orders" */);
const DashboardScrapbooks = () => import('~/Members/Dashboard/Pages/Scrapbooks' /* webpackChunkName: "chunk-dashboard-scrapbooks" */);
const DashboardDailyUpdates = () => import('~/Members/Dashboard/Pages/DailyUpdates' /* webpackChunkName: "chunk-dashboard-subscriptions" */);

Vue.component('MemberDashboardPageRecentOrders', DashboardRecentOrders);
Vue.component('MemberDashboardPageScrapbooks', DashboardScrapbooks);
Vue.component('MemberDashboardPageDailyUpdates', DashboardDailyUpdates);
