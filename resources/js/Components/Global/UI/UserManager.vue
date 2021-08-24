<template>
    <div v-if="!isLoggedIn()" class="lg:flex lg:items-center">
        <!-- mobile -->
        <div class="md:pt-1 lg:hidden">
            <div @click.stop="toggleMobileOptions()">
                <font-awesome-icon :icon="['fas', 'user']"></font-awesome-icon>
            </div>

            <div class="mt-2 absolute w-full left-0" v-if="showMobileOptions" v-click-outside="toggleMobileOptions">
                <ul class="text-right text-lg bg-white border-blue rounded text-blue font-semibold">
                    <li class="p-3 cursor-pointer" @click="showLoginModal">Log In</li>
                    <li class="p-3 cursor-pointer" @click="showRegistrationModal">Register</li>
                </ul>
            </div>
        </div>

        <div class="hidden lg:flex space-x-3 text-base">
            <div
                class="py-1 px-3 leading-none rounded-full border border-white cursor-pointer hover:bg-blue transition-all"
                @click="showLoginModal">
                Log In
            </div>
            <div
                class="py-1 px-3 leading-none rounded-full border border-white bg-white text-blue cursor-pointer hover:bg-blue hover:text-white transition-all"
                @click="showRegistrationModal">
                Register
            </div>
        </div>

        <portal to="modal" v-if="modalComponent">
            <modal closable :title="modalTitle">
                <component :is="modalComponent"/>
            </modal>
        </portal>
    </div>

    <div v-else class="md:pt-1" @mouseenter="isGt('md') ? showDropdown = true : null"
         @mouseleave="isGt('md') ? showDropdown = false : null">
        <div @click="goToDashboard()">
            <font-awesome-icon :icon="['fas', 'user']"></font-awesome-icon>
        </div>

        <transition
            enter-active-class="duration-400 ease-out"
            enter-class="translate-x-full opacity-0"
            enter-to-class="translate-x-0 opacity-1"
            leave-active-class="duration-200 ease-in"
            leave-class="translate-x-0 opacity-1"
            leave-to-class="translate-x-full opacity-0"
        >
            <div v-if="showDropdown" class="transition transform absolute right-0 w-40 z-max">
                <ul class="text-lg bg-white text-black mt-1 rounded-b-lg shadow-lg">
                    <li class="border-blue border-b hover:bg-blue-light hover:bg-opacity-50 transition-all" v-if="isGt('md')">
                        <a class="block py-2 pl-2" href="/member/dashboard">
                            My Dashboard
                        </a>
                    </li>
                    <template v-else>
                        <li class="border-blue border-b hover:bg-blue-light hover:bg-opacity-50 transition-all">
                            <a class="block py-2 pl-2" href="/member/dashboard/scrapbooks">
                                My Scrapbooks
                            </a>
                        </li>
                        <li class="border-blue border-b hover:bg-blue-light hover:bg-opacity-50 transition-all">
                            <a class="block py-2 pl-2" href="/member/dashboard/orders">
                                Purchase History
                            </a>
                        </li>
                        <li class="border-blue border-b hover:bg-blue-light hover:bg-opacity-50 transition-all">
                            <a class="block py-2 pl-2" href="/member/dashboard/daily-updates">
                                Daily Updates
                            </a>
                        </li>
                        <li class="border-blue border-b hover:bg-blue-light hover:bg-opacity-50 transition-all">
                            <a class="block py-2 pl-2" href="/member/dashboard/details">
                                My Details
                            </a>
                        </li>
                    </template>
                    <li class="hover:bg-blue-light hover:bg-opacity-50 transition-all">
                        <a class="block py-2 pl-2" href="/member/logout">
                            Log Out
                        </a>
                    </li>
                </ul>
            </div>
        </transition>
    </div>
</template>

<script>
import InteractsWithUser from "../../../Mixins/InteractsWithUser";
import ClickOutside from 'vue-click-outside';
import ResponsiveOptions from "@/Mixins/ResponsiveOptions";

const Modal = () => import('./Modal' /* webpackChunkName: "chunk-modal" */)

export default {
    components: {
        modal: Modal,
    },

    mixins: [InteractsWithUser, ResponsiveOptions],

    // do not forget this section
    directives: {
        ClickOutside
    },

    data: () => ({
        showDropdown: false,
        showMobileOptions: false,
        modalComponent: null,
        modalTitle: null,
    }),

    mounted() {
        this.$root.$on('modal-closed', () => {
            document.querySelector('body').classList.remove('overflow-hidden');
            this.modalComponent = null;
        });
    },

    methods: {
        toggleMobileOptions() {
            this.showMobileOptions = !this.showMobileOptions;
        },

        showLoginModal() {
            this.modalComponent = 'member-login-form';
            this.modalTitle = 'Login';
        },

        showRegistrationModal() {
            this.modalComponent = 'member-register-form';
            this.modalTitle = 'Register';
        },

        goToDashboard() {
            if (this.isLte('md')) {
                this.showDropdown = !this.showDropdown;

                return;
            }

            window.location = '/member/dashboard';
        }
    }
}
</script>
