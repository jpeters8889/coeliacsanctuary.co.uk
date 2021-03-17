import Vue from "vue";

const Comments = () => import("~/Modules/Comments/Comments" /* webpackChunkName: "chunk-comments" */);
const CommentForm = () => import("~/Modules/Comments/CommentForm" /* webpackChunkName: "chunk-comment-form" */);

Vue.component('comment-form', CommentForm);
Vue.component('comments', Comments);
