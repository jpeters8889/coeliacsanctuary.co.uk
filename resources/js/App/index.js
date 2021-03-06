import Vue from 'vue';
import Toasted from 'vue-toasted';
import request from "../Utilities/RequestHandler";
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
            duration: 3000,
        })
        Vue.use(PortalVue);
        Vue.use(VueScrollTo);

        new Vue({
            el: '#coeliac',
            mounted: () => {
                this.updateLazyloader();
            },
        });

        this.addWidthToImages();
    }

    addWidthToImages() {
        document.querySelectorAll('img').forEach((image) => {
            let width = image.width;

            if(width === 0 || image.classList.contains('recipe-img')) {
                width = image.closest('div').offsetWidth;
            }

            if (image.classList.contains('absolute')) {
                return;
            }

            if (image.hasAttribute('data-src')) {
                let attribute = new URL(image.getAttribute('data-src'));
                attribute.searchParams.delete('size');
                attribute.searchParams.append('size', width.toString());

                image.setAttribute('data-src', attribute.toString());
            }

            if (image.hasAttribute('src')) {
                let attribute = new URL(image.getAttribute('src'));
                attribute.searchParams.delete('size');
                attribute.searchParams.append('size', width.toString());

                image.setAttribute('src', attribute.toString());
            }
        });
    }

    updateLazyloader() {
        this.addWidthToImages();
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
