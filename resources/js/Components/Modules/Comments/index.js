import Vue from "vue";

const Comments = () => import("~/Modules/Comments/Comments" /* webpackChunkName: "chunk-comments" */);
const CommentForm = () => import("~/Modules/Comments/CommentForm" /* webpackChunkName: "chunk-comment-form" */);

Vue.component('modules-comment-form', CommentForm);
Vue.component('module-comments', Comments);
