import Vue from 'vue';
import QuickSearch from '~/Search/UI/QuickSearch';
import HeaderSearch from '~/Search/UI/HeaderSearch';

const BlogSearch = () => import('~/Search/UI/BlogSearch' /* webpackChunkName: "chunk-blog-search" */);
const RecipeSearch = () => import('~/Search/UI/RecipeSearch' /* webpackChunkName: "chunk-recipe-search" */);
const ReviewSearch = () => import('~/Search/UI/ReviewSearch' /* webpackChunkName: "chunk-review-search" */);
const WhereToEatSearch = () => import('~/Search/UI/WhereToEatSearch' /* webpackChunkName: "chunk-wte-search" */);

Vue.component('SearchUiHeader', HeaderSearch);
Vue.component('SearchUiQuick', QuickSearch);
Vue.component('SearchUiBlogWidget', BlogSearch);
Vue.component('SearchUiRecipeWidget', RecipeSearch);
Vue.component('SearchUiReviewWidget', ReviewSearch);
Vue.component('SearchUiWheretoeatWidget', WhereToEatSearch);
