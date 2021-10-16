import Vue from 'vue';

const Comments = () => import('~/Modules/Comments/Comments' /* webpackChunkName: "chunk-comments" */);
const CommentForm = () => import('~/Modules/Comments/CommentForm' /* webpackChunkName: "chunk-comment-form" */);

Vue.component('ModulesCommentForm', CommentForm);
Vue.component('ModuleComments', Comments);
