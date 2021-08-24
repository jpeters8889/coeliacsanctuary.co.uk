<template>
    <div class="fixed z-max inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">

            <transition
                enter-active-class="ease-out duration-300"
                enter-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="duration-200 ease-in"
                leave-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div
                    class="fixed inset-0 bg-black bg-opacity-80 transition-all"
                    aria-hidden="true"
                     @click.exact.once.stop="close()"
                    v-if="show"
                ></div>
            </transition>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <transition
                enter-active-class="ease-out duration-300"
                enter-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-75"
                enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                leave-active-class="duration-200 ease-in"
                leave-class="opacity-100 translate-y-0 sm:scale-100"
                leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-75"
            >
                <div
                    class="mx-4 inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle"
                    v-if="show"
                    :class="computedClasses"
                >
                    <div v-if="title || closable"
                         class="flex justify-between bg-grey-off-light leading-none items-center border-b border-grey">
                        <div class="flex-1 pl-3 text-grey font-semibold text-lg" v-if="title">
                            {{ title }}
                        </div>
                        <div
                            v-if="closable"
                            @click="close()"
                            :class="!title ? 'w-full' : ''"
                            class="flex justify-end p-3 text-grey-off-dark hover:text-grey cursor-pointer text-xl transition-all"
                        >
                            <font-awesome-icon :icon="['fas', 'times']"></font-awesome-icon>
                        </div>
                    </div>

                    <div>
                        <slot></slot>
                    </div>

                    <div v-if="footer"
                         class="flex justify-between bg-grey-off-light leading-none items-center border-t border-grey">
                        <div class="flex-1 p-3 text-grey text-sm" v-html="footer"></div>
                    </div>
                </div>
            </transition>
        </div>
    </div>


</template>

<script>
export default {
    props: {
        name: {
            type: String,
            default: '',
        },
        title: {
            type: String,
            default: null,
            required: false,
        },
        footer: {
            type: String,
            default: null,
            required: false,
        },
        closable: {
            type: Boolean,
            default: () => true,
            required: false,
        },
        modalClasses: {
            type: Array | String,
            default: () => [],
        },
        small: {
            type: Boolean,
            default: false,
        },
        large: {
            type: Boolean,
            default: false,
        }
    },

    data: () => ({
        show: false,
    }),

    mounted() {
        document.querySelector('body').classList.add('overflow-hidden');

        this.$root.$on('close-modal', (modal) => {
            if (!modal || modal === this.name) {
                this.close();
            }
        });

        setTimeout(() => this.show = true, 50);
    },

    methods: {
        close() {
            if(!this.closable) {
                return;
            }

            document.querySelector('body').classList.remove('overflow-hidden');
            this.$root.$emit('modal-closed', this.name);
        }
    },

    computed: {
        computedClasses: function () {
            let classes = this.modalClasses;

            if (!Array.isArray(classes)) {
                classes = classes.split(' ');
            }

            let sizeClass = 'max-w-modal';

            if (this.small) {
                sizeClass = 'max-w-modal-small';
            }

            if(this.large) {
                sizeClass = 'max-w-modal-large';
            }

            classes.push(sizeClass);

            return classes;
        }
    }
}
</script>
