import Vue from 'vue';
import FullPageLoader from '~/Global/Layout/FullPageLoader';
import TopBar from '~/Global/Layout/TopBar';
import Announcement from '~/Global/Layout/Announcement';
import Breadcrumbs from '~/Global/Layout/Breadcrumbs';
import CoeliacIcon from '~/Global/Layout/CoeliacIcon';
import FooterNewsletter from '~/Global/Layout/FooterNewsletter';
import MobileNav from '~/Global/Layout/MobileNav';

Vue.component('GlobalLayoutAnnouncement', Announcement);
Vue.component('GlobalLayoutBreadcrumbs', Breadcrumbs);
Vue.component('GlobalLayoutCoeliacIcon', CoeliacIcon);
Vue.component('GlobalLayoutFooterNewsletter', FooterNewsletter);
Vue.component('GlobalLayoutFullPageLoader', FullPageLoader);
Vue.component('GlobalLayoutMobileNav', MobileNav);
Vue.component('GlobalLayoutTopBar', TopBar);
