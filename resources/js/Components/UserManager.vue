<template>
    <div v-if="!isLoggedIn()" class="lg:flex lg:items-center">
        <!-- mobile -->
        <div class="lg:hidden">
            <div @click.stop="toggleMobileOptions()">
                <font-awesome-icon :icon="['fas', 'user']"></font-awesome-icon>
            </div>

            <div class="absolute w-full left-0" v-if="showMobileOptions" v-click-outside="toggleMobileOptions">
                <ul class="text-right text-lg bg-white border-blue rounded text-blue font-semibold">
                    <li class="p-3" @click="showLoginModal">Log In</li>
                    <li class="p-3" @click="showRegistrationModal">Register</li>
                </ul>
            </div>
        </div>

        <div class="hidden lg:flex space-x-3 text-base">
            <div class="py-1 px-3 leading-none rounded-full border-white" @click="showLoginModal">Log In</div>
            <div class="py-1 px-3 leading-none rounded-full bg-white text-blue" @click="showRegistrationModal">Register</div>
        </div>

        <portal to="modal" v-if="modalComponent">
            <modal modal-classes="w-full">
                <component :is="modalComponent" />
            </modal>
        </portal>
    </div>

    <div v-else>

    </div>
</template>

<script>
import InteractsWithUser from "../Mixins/InteractsWithUser";
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
            this.modalComponent = 'login-form';
        },

        showRegistrationModal() {
            this.modalComponent = 'register-form';
        }
    }
}
</script>
