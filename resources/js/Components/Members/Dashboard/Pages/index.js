import Vue from "vue";

const DashboardRecentOrders = () => import('~/Members/Dashboard/Pages/RecentOrders' /* webpackChunkName: "chunk-dashboard-recent-orders" */)
const DashboardScrapbooks = () => import('~/Members/Dashboard/Pages/Scrapbooks' /* webpackChunkName: "chunk-dashboard-scrapbooks" */)
const DashboardDailyUpdates = () => import('~/Members/Dashboard/Pages/DailyUpdates' /* webpackChunkName: "chunk-dashboard-subscriptions" */)

Vue.component('member-dashboard-page-recent-orders', DashboardRecentOrders)
Vue.component('member-dashboard-page-scrapbooks', DashboardScrapbooks)
Vue.component('member-dashboard-page-daily-updates', DashboardDailyUpdates)
