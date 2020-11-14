import Vue from 'vue';
import Toasted from 'vue-toasted';
import VTooltip from 'v-tooltip';
import request from "./Utilities/RequestHandler";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import PortalVue from 'portal-vue'
import LazyLoad from "vanilla-lazyload";
import VueScrollTo from 'vue-scrollto';

export default class Coeliac {
    constructor(config) {
        this.config = config;
        this.vue = new Vue();
        this.hasBuilt = false;

        this.lazyLoader = new LazyLoad({
            elements_selector: ".lazy",
            threshold: 10,
            cancel_on_exit: true,
            callback_loaded: (img) => {
                img.removeAttribute('width');
                img.removeAttribute('height');
                img.style.paddingBottom = 0;
            },
        });
    }

    build() {
        Vue.component('font-awesome-icon', FontAwesomeIcon);
        Vue.use(Toasted, {
            position: "bottom-right",
            duration: 6000,
        })
        Vue.use(VTooltip);
        Vue.use(PortalVue);
        Vue.use(VueScrollTo);

        new Vue({
            el: '#coeliac',
            mounted: () => {
                this.updateLazyloader();
            }
        });
    }

    updateLazyloader() {
        this.lazyLoader.update();
    }

    request() {
        return request;
    }

    $on(event, callback) {
        this.vue.$on(event, callback);
    }

    $emit(event, ...args) {
        this.vue.$emit(event, ...args)
    }

    getAsset(file, directory = 'images') {
        return '/assets/' + directory + '/' + file;
    }

    success(message) {
        Vue.toasted.show(message, {type: 'success'});
    }

    error(message) {
        Vue.toasted.show(message, {type: 'error'});
    }
}
