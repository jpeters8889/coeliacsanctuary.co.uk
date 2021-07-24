<template>
    <div>
        <div class="cursor-pointer js-mobile-nav-trigger" @click="showNav = true">
            <font-awesome-icon :icon="['fas', 'bars']"></font-awesome-icon>
        </div>

        <div class="h-screen bg-blue fixed overflow-scroll top-0 left-0 w-full h-full flex flex-col z-max js-mobile-nav"
             v-show="showNav">
            <div class="p-1 flex justify-end text-3xl p-2 js-mobile-nav-close-trigger" @click="showNav = false">
                <font-awesome-icon :icon="['fas', 'times']"></font-awesome-icon>
            </div>
            <nav class="flex-1 flex items-center">
                <ul class="flex flex-col w-full">
                    <li v-for="link in links" class="text-center p-1">
                        <a v-if="link.link" :href="link.link">{{ link.label }}</a>
                        <a v-if="link.callback" class="cursor-pointer" @click="link.callback()">{{ link.label }}</a>
                    </li>
                </ul>
            </nav>
        </div>

        <portal to="modal" v-if="showContact">
            <modal>
                <contact-form></contact-form>
            </modal>
        </portal>
    </div>
</template>

<script>
import GoogleEvents from "@/Mixins/GoogleEvents";

const ContactForm = () => import('~/Contact/Form' /* webpackChunkName: "chunk-contact-form" */)
const Modal = () => import('~/Global/UI/Modal' /* webpackChunkName: "chunk-modal" */)

export default {
    mixins: [GoogleEvents],

    components: {
        'contact-form': ContactForm,
        'modal': Modal,
    },

    data: () => ({
        showNav: false,
        showContact: false,
        links: [],
    }),

    mounted() {
        this.$root.$on('modal-closed', () => {
            this.showContact = false;
        });

        this.links = [
            {
                label: 'Home',
                link: '/',
            },
            {
                label: 'Shop',
                link: '/shop',
            },
            {
                label: 'Blogs',
                link: '/blog',
            },
            {
                label: 'Eating Out',
                link: '/eating-out',
            },
            {
                label: 'Recipes',
                link: '/recipe',
            },
            {
                label: 'Collections',
                link: '/collection',
            },
            {
                label: 'Info',
                link: '/info',
            },
            {
                label: 'About Us',
                link: '/about',
            },
            {
                label: 'FAQ',
                link: '/faq',
            },
            {
                label: 'Contact',
                callback: function () {
                    this.showContact = true;
                    this.showNav = false;
                }.bind(this)
            },
        ];
    },

    watch: {
        showNav: function (value) {
            if (value) {
                this.googleEvent('event', 'mobile-nav', {
                    event_category: 'toggled',
                });

                document.querySelector('body').classList.add('overflow-hidden');
                return;
            }

            document.querySelector('body').classList.remove('overflow-hidden');
        }
    }
}
</script>
