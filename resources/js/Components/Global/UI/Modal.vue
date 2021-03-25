<template>
    <div class="z-max fixed inset-0 w-full h-full bg-black-80 flex justify-center items-center" @click.self="close()">
        <div
            class="h-auto max-h-3/4 shadow p-2 border-2 border-blue-light w-auto rounded-lg bg-blue-light overflow-y-scroll"
            :class="computedClasses">
            <div class="h-full relative">
                <div
                    class="absolute top-0 right-0 bg-white p-1 -mt-1 -mr-1 leading-none z-50 rounded border border-black cursor-pointer transition-bg"
                    @click="close()">
                    <font-awesome-icon :icon="['fas', 'times']"></font-awesome-icon>
                </div>
                <div class="h-full w-full bg-white-80 p-2 rounded">
                    <slot></slot>
                </div>
            </div>
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
        modalClasses: {
            type: Array | String,
            default: () => {
                return [];
            },
        },
        small: {
            type: Boolean,
            default: false,
        }
    },

    mounted() {
        document.querySelector('body').classList.add('overflow-hidden');

        this.$root.$on('close-modal', (modal) => {
            if (!modal || modal === this.name) {
                this.close();
            }
        });
    },

    methods: {
        close() {
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

            classes.push(sizeClass);

            return classes;
        }
    }
}
</script>
