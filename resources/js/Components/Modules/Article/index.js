import Vue from 'vue';

const ArticleHeader = () => import('~/Modules/Article/ArticleHeader' /* webpackChunkName: "chunk-article-header" */);
const ArticleImage = () => import('~/Modules/Article/ArticleImage' /* webpackChunkName: "chunk-article-image" */);

Vue.component('ArticleHeader', ArticleHeader);
Vue.component('ArticleImage', ArticleImage);
