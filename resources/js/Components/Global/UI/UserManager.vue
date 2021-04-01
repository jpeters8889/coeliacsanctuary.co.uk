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
                class="py-1 px-3 leading-none rounded-full border border-white cursor-pointer hover:bg-blue transition-both"
                @click="showLoginModal">
                Log In
            </div>
            <div
                class="py-1 px-3 leading-none rounded-full border border-white bg-white text-blue cursor-pointer hover:bg-blue hover:text-white transition-both"
                @click="showRegistrationModal">
                Register
            </div>
        </div>

        <portal to="modal" v-if="modalComponent">
            <modal>
                <component :is="modalComponent"/>
            </modal>
        </portal>
    </div>

    <div v-else class="md:pt-1" @mouseenter="showDropdown = true" @mouseleave="showDropdown = false">
        <a href="/member/dashboard">
            <font-awesome-icon :icon="['fas', 'user']"></font-awesome-icon>
        </a>

        <div v-if="showDropdown" class="absolute right-0 w-40">
            <ul class="text-lg bg-white text-black mt-1 rounded-b-lg shadow-lg">
                <li class="border-blue border-b hover:bg-blue-light-50 transition-bg">
                    <a class="block py-2 pl-2" href="/member/dashboard">
                        My Dashboard
                    </a>
                </li>
                <li class="hover:bg-blue-light-50 transition-bg">
                    <a class="block py-2 pl-2" href="/member/logout">
                        Log Out
                    </a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import InteractsWithUser from "../../../Mixins/InteractsWithUser";
import ClickOutside from 'vue-click-outside';

const Modal = () => import('./Modal' /* webpackChunkName: "chunk-modal" */)

export default {
    components: {
        modal: Modal,
    },

    mixins: [InteractsWithUser],

    // do not forget this section
    directives: {
        ClickOutside
    },

    data: () => ({
        showDropdown: false,
        showMobileOptions: false,
        modalComponent: null,
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
        },

        showRegistrationModal() {
            this.modalComponent = 'member-register-form';
        }
    }
}
</script>
