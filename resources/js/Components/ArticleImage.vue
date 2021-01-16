<template>
    <div>
        <div :class="classMap">
            <img :data-src="src" :src="lazyLoadSrc" :alt="title" loading="lazy" class="lazy w-full h-auto" style="cursor: zoom-in" @click="zoom = true"/>
            <div v-if="title" class="text-center text-sm mt-2 leading-none">{{ title }}</div>
        </div>

        <portal to="modal" v-if="zoom">
            <modal>
                <img :src="src" :alt="title" class="max-w-full" />
                <div v-if="title" class="text-center text-sm mt-2 leading-none">{{ title }}</div>
            </modal>
        </portal>
    </div>
</template>

<script>
    import LazyLoadsImages from "../Mixins/LazyLoadsImages";
    import GoogleEvents from "../Mixins/GoogleEvents";
    const Modal = () => import('./Modal' /* webpackChunkName: "prefetch-modal" */)

    export default {
        mixins: [GoogleEvents, LazyLoadsImages],

        components: {
            'modal': Modal,
        },

        props: {
            src: {
                required: true,
                type: String,
            },
            title: {
                type: String,
                default: null,
            },
            position: {
                type: String,
                default: 'left',
            }
        },

        data: () => ({
           zoom: false,
        }),

        mounted() {
            this.$root.$on('modal-closed', () => {
                this.zoom = false;
            });

            this.loadLazyImages();
        },

        computed: {
            classMap() {
                const classes = [
                    'w-auto',
                    'p-2',
                    'mx-0',
                    'my-2',
                    'sm:m-2',
                    'bg-blue-20',
                ];

                if(this.position !== 'fullwidth') {
                    classes.push('sm:max-w-1/2', 'lg:max-w-2/5');
                }

                if(this.position === 'left') {
                    classes.push('sm:ml-0', 'float-left')
                }

                if(this.position === 'right') {
                    classes.push('sm:mr-0', 'float-right');
                }

                return classes;
            }
        },

        watch: {
            zoom: function() {
                if(this.zoom) {
                    this.googleEvent('event', 'article', {
                        event_category: 'viewed-image',
                        event_label: this.src,
                    });
                }
            }
        }
    }
</script>
