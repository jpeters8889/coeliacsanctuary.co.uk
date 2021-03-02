import Vue from 'vue';

const CoeliacIcon = () => import("./Components/CoeliacIcon" /* webpackChunkName: "preload-coeliac-icon" */);
const MobileNav = () => import("./Components/MobileNav" /* webpackChunkName: "preload-mobile-nav" */);
const HeaderSearch = () => import("./Components/HeaderSearch" /* webpackChunkName: "preload-header-search" */);
const HomepageHeros = () => import("./Components/HomepageHeros" /* webpackChunkName: "chunk-home-heros" */);
const LinkButton = () => import("./Components/LinkButton" /* webpackChunkName: "chunk-link-button" */);
const TopBar = () => import("./Components/TopBar" /* webpackChunkName: "preload-top-bar" */);
const NumberCountUp = () => import("./Components/NumberCountUp" /* webpackChunkName: "chunk-number-count" */);
const FooterNewsletter = () => import("./Components/FooterNewsletter" /* webpackChunkName: "preload-footer-newsletter" */);
const Breadcrumbs = () => import("./Components/Breadcrumbs" /* webpackChunkName: "chunk-breadcrumbs" */);
const ModuleListIndex = () => import("./Components/ModuleListIndex" /* webpackChunkName: "chunk-module-list-index" */);
const Accordion = () => import("./Components/Accordion" /* webpackChunkName: "chunk-accordion" */);
const Widget = () => import("./Components/Widget" /* webpackChunkName: "chunk-widget" */);
const NewsletterSignup = () => import("./Components/Widgets/NewsletterSignup" /* webpackChunkName: "chunk-newsletter-signup" */);
const BlogSearch = () => import("./Components/Widgets/BlogSearch" /* webpackChunkName: "chunk-blog-search" */);
const Comments = () => import("./Components/Comments" /* webpackChunkName: "chunk-comments" */);
const CommentForm = () => import("./Components/CommentForm" /* webpackChunkName: "chunk-comment-form" */);
const RecipeImage = () => import("./Components/RecipeImage" /* webpackChunkName: "chunk-recipe-image" */);
const RecipeSearch = () => import("./Components/Widgets/RecipeSearch" /* webpackChunkName: "chunk-recipe-search" */);
const Tabs = () => import("./Components/Tabs" /* webpackChunkName: "chunk-tabs" */);
const Tab = () => import("./Components/Tab" /* webpackChunkName: "chunk-tab" */);
const WhereToEatMap = () => import("./Components/WhereToEatMap" /* webpackChunkName: "chunk-wte-map" */);
const WhereToEatList = () => import("./Components/WhereToEatList" /* webpackChunkName: "chunk-wte-list" */);
const StaticMap = () => import("./Components/StaticMap" /* webpackChunkName: "chunk-static-map" */);
const Stars = () => import("./Components/Stars" /* webpackChunkName: "chunk-stars" */);
const WhereToEatPlaceRequestForm = () => import("./Components/WhereToEatPlaceRequestForm" /* webpackChunkName: "chunk-wte-place-request" */);
const ReviewSearch = () => import("./Components/Widgets/ReviewSearch" /* webpackChunkName: "chunk-review-search" */);
const ArticleHeader = () => import("./Components/ArticleHeader" /* webpackChunkName: "chunk-article-header" */);
const ArticleImage = () => import("./Components/ArticleImage" /* webpackChunkName: "chunk-article-image" */);
const ContactTrigger = () => import("./Components/ContactTrigger" /* webpackChunkName: "chunk-contact-trigger" */);
const WhereToEatSearch = () => import("./Components/Widgets/WhereToEatSearch" /* webpackChunkName: "chunk-wte-search" */);
const AddBasketTrigger = () => import("./Components/AddBasketTrigger" /* webpackChunkName: "chunk-add-basket-trigger" */);
const BasketHeaderWidget = () => import("./Components/BasketHeaderWidget" /* webpackChunkName: "chunk-basket-header-widget" */);
const BasketSideBar = () => import("./Components/BasketSideBar" /* webpackChunkName: "chunk-basket-sidebar" */);
const BasketQuickLink = () => import("./Components/BasketQuickLink" /* webpackChunkName: "chunk-basket-quick-link" */);
const ProductImages = () => import("./Components/ProductImages" /* webpackChunkName: "chunk-product-images" */);
const ProductAddToBasket = () => import("./Components/ProductAddToBasket" /* webpackChunkName: "chunk-product-add-basket" */);
const BasketPage = () => import("./Components/BasketPage" /* webpackChunkName: "chunk-basket-page" */);
const BasketQuantitySwitcher = () => import("./Components/BasketQuantitySwitcher" /* webpackChunkName: "chunk-basket-quantity-switcher" */);
const FullPageLoader = () => import("./Components/FullPageLoader" /* webpackChunkName: "chunk-page-loader" */);
const QuickSearch = () => import("./Components/QuickSearch" /* webpackChunkName: "preload-quick-search" */);
const Announcement = () => import("./Components/Announcement" /* webpackChunkName: "chunk-announcements" */);
const PopupCta = () => import("./Components/PopupCta" /* webpackChunkName: "preload-popup-cta" */);
const GoogleAd = () => import('./Components/GoogleAd' /* webpackChunkName: "preload-google-ad" */);
const WhereToEatQuickSearch = () => import('./Components/WhereToEatQuickSearch' /* webpackChunkName: "chunk-wte-quick-search" */);
const SiteSearch = () => import('./Components/SiteSearch' /* webpackChunkName: "chunk-site-search" */)
const LoginForm = () => import('./Components/LoginForm' /* webpackChunkName: "chunk-login-form" */)
const RegisterForm = () => import('./Components/RegisterForm' /* webpackChunkName: "chunk-register-form" */)
const LoginTrigger = () => import('./Components/LoginTrigger' /* webpackChunkName: "preload-login-trigger" */)
const RegisterTrigger = () => import('./Components/RegisterTrigger' /* webpackChunkName: "preload-register-trigger" */)
const VerifyEmailResendTrigger = () => import('./Components/VerifyEmailResendTrigger' /* webpackChunkName: "chunk-resend-verify-email" */)
const DashboardNavigation = () => import('./Components/DashboardNavigation' /* webpackChunkName: "chunk-member-dashboard" */)
const DashboardRecentOrders = () => import('./Components/DashboardRecentOrders' /* webpackChunkName: "chunk-dashboard-recent-orders" */)
const DashboardUserDetails = () => import('./Components/DashboardUserDetails' /* webpackChunkName: "chunk-dashboard-user-details" */)
const OrderCompleteCreateAccount = () => import('./Components/OrderCompleteCreateAccount' /* webpackChunkName: "chunk-order-complete-create-account" */)
const DashboardScrapbooks = () => import('./Components/DashboardScrapbooks' /* webpackChunkName: "chunk-dashboard-scrapbooks" */)
const WhereToEatDailyUpdateSubscribe = () => import('./Components/WhereToEatDailyUpdateSubscribe' /* webpackChunkName: "chunk-wte-subscribe" */)
const DashboardDailyUpdates = () => import('./Components/DashboardDailyUpdates' /* webpackChunkName: "chunk-dashboard-subscriptions" */)

Vue.component('accordion', Accordion);
Vue.component('add-basket-trigger', AddBasketTrigger);
Vue.component('announcement', Announcement);
Vue.component('article-header', ArticleHeader);
Vue.component('article-image', ArticleImage);
Vue.component('basket-header-widget', BasketHeaderWidget);
Vue.component('basket-quick-link', BasketQuickLink);
Vue.component('basket-page', BasketPage);
Vue.component('basket-quantity-swticher', BasketQuantitySwitcher);
Vue.component('basket-sidebar', BasketSideBar);
Vue.component('breadcrumbs', Breadcrumbs);
Vue.component('coeliac-icon', CoeliacIcon);
Vue.component('coeliac-home-heros', HomepageHeros);
Vue.component('comment-form', CommentForm);
Vue.component('comments', Comments);
Vue.component('contact-trigger', ContactTrigger);
Vue.component('dashboard-navigation', DashboardNavigation);
Vue.component('dashboard-recent-orders', DashboardRecentOrders)
Vue.component('dashboard-scrapbooks', DashboardScrapbooks)
Vue.component('dashboard-daily-updates', DashboardDailyUpdates)
Vue.component('dashboard-user-details', DashboardUserDetails)
Vue.component('footer-newsletter', FooterNewsletter);
Vue.component('full-page-loader', FullPageLoader);
Vue.component('google-ad', GoogleAd);
Vue.component('header-search', HeaderSearch);
Vue.component('link-button', LinkButton);
Vue.component('login-form', LoginForm);
Vue.component('login-trigger', LoginTrigger);
Vue.component('register-trigger', RegisterTrigger);
Vue.component('mobile-nav', MobileNav);
Vue.component('module-list-index', ModuleListIndex);
Vue.component('number-counter', NumberCountUp);
Vue.component('order-complete-create-account', OrderCompleteCreateAccount);
Vue.component('popup-cta', PopupCta);
Vue.component('product-add-basket', ProductAddToBasket);
Vue.component('product-images', ProductImages);
Vue.component('quick-search', QuickSearch);
Vue.component('recipe-image', RecipeImage);
Vue.component('register-form', RegisterForm);
Vue.component('site-search', SiteSearch);
Vue.component('static-map', StaticMap);
Vue.component('stars', Stars);
Vue.component('tab', Tab);
Vue.component('tabs', Tabs);
Vue.component('top-bar', TopBar);
Vue.component('verify-email-resend-trigger', VerifyEmailResendTrigger);
Vue.component('wheretoeat-list', WhereToEatList);
Vue.component('wheretoeat-map', WhereToEatMap);
Vue.component('wheretoeat-place-request-form', WhereToEatPlaceRequestForm);
Vue.component('wheretoeat-quick-search', WhereToEatQuickSearch);
Vue.component('wheretoeat-notifications-daily-updates-subscribe', WhereToEatDailyUpdateSubscribe);
Vue.component('widget', Widget);

Vue.component('widget-blog-search', BlogSearch);
Vue.component('widget-newsletter-signup', NewsletterSignup);
Vue.component('widget-recipe-search', RecipeSearch);
Vue.component('widget-review-search', ReviewSearch);
Vue.component('widget-wheretoeat-search', WhereToEatSearch);
