<template>
    <div :class="wrapperClasses">
        <div :class="innerWrapperClasses">
            <div :class="imageClasses" class="flex flex-col">
                <a :href="item.link">
                    <img :data-src="item.main_image" :alt="item.title" loading="lazy" class="lazy w-full"
                         :src="index > 0 ? lazyLoadSrc : item.main_image" v-if="module !== 'recipes'">
                    <recipe-image :src="item.main_image" :alt="item.title" v-else></recipe-image>
                </a>
                <template v-if="module==='recipes' && layout === 'list'">
                    <ul class="flex flex-wrap justify-center -mx-2 sm:justify-start">
                        <li v-for="feature in item.features"
                            class="w-1/6 m-2 flex flex-col max-w-recipe-feature text-xs leading-none text-center">
                            <img :data-src="feature.image" loading="lazy" class="lazy" :alt="feature.feature"
                                 :src="lazyLoadSrc">
                            <span class="font-semibold mt-1">{{ feature.feature }}</span>
                        </li>
                    </ul>
                </template>
            </div>
            <div :class="textClasses">
                <a :href="item.link"
                   :class="headerClasses">
                    <h2 v-html="item.title"></h2>
                </a>
                <template v-if="module==='reviews'">
                    <span class="font-semibold text-xs" :class="layout === 'tiles' ? 'text-center' : ''">
                        {{ item.eatery.type.name }} in {{ item.eatery.town.town }}, {{ item.eatery.county.county }}
                    </span>
                    <stars class="my-2" :stars="item.overall_rating"></stars>
                </template>
                <template v-if="module==='recipes'">
                    <ul class="flex flex-wrap justify-center -mx-2" v-if="layout === 'grid'">
                        <li v-for="feature in item.features"
                            class="w-1/4 m-2 flex flex-col max-w-recipe-feature text-xs leading-none text-center">
                            <img loading="lazy" class="lazy" :data-src="feature.image" :alt="feature.feature"
                                 :src="lazyLoadSrc">
                            <span class="font-semibold mt-1">{{ feature.feature }}</span>
                        </li>
                    </ul>
                    <p class="mb-1 flex font-semibold">
                        Makes {{ item.serving_size }}<br/>
                        {{ item.nutrition.calories }} Calories per {{ item.per }}
                    </p>
                </template>
                <p class="mb-1 flex-1 h-full" v-html="description"></p>
                <div class="text-sm flex flex-wrap justify-between">
                    <p>{{ formatDate(item.created_at) }}</p>
                    <p class="text-right" v-if="module !== 'collection'" v-text="commentsText(item.comments_count)"></p>
                    <p class="text-right" v-else v-text="collectionItemsText(item.items_count)"></p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import FormatsDates from "@/Mixins/FormatsDates";
import LazyLoadsImages from "@/Mixins/LazyLoadsImages";

export default {
    mixins: [FormatsDates, LazyLoadsImages],

    props: {
        module: {
            required: true,
            validator: (value) => {
                return ['blogs', 'collection', 'recipes', 'reviews'].indexOf(value) !== -1;
            }
        },
        item: {
            required: true,
            type: Object
        },
        index: {
            required: true,
            type: Number,
        },
        page: {
            required: true,
            type: Number,
        },
        layout: {
            type: String,
            default: 'tiles',
            validator: (value) => {
                return ['tiles', 'list'].indexOf(value) !== -1;
            }
        },
        hasFilters: {
            type: Boolean,
            default: false,
        }
    },

    mounted() {
        this.loadLazyImages();

        this.$root.$on('layout-change', (layout) => {
            setTimeout(() => {
                this.loadLazyImages();
            }, 200);
        });
    },

    methods: {
        commentsText(count) {
            if (count === 0) {
                return 'No Comments';
            }

            if (count === 1) {
                return '1 Comment';
            }

            return `${count} comments`;
        },

        collectionItemsText(count) {
            if (count === 1) {
                return '1 item in this collection';
            }

            return `${count} items in this collection`;
        }
    },

    computed: {
        description() {
            if (this.page === 1 && this.index === 0) {
                return this.item.description || this.item.meta_description;
            }

            return this.item.meta_description;
        },

        wrapperClasses() {
            if (this.layout === 'list') {
                return ['w-full'];
            }

            if (this.page === 1 && !this.hasFilters) {
                if (this.index === 0) {
                    return ['w-full', 'p-2'];
                }

                if (this.index > 0 && this.index < 3) {
                    return ['w-full', 'md:w-1/2', 'p-2'];
                }
            }

            return ['w-full', 'md:w-1/3', 'p-2'];
        },

        innerWrapperClasses() {
            if (this.layout === 'list') {
                return ['flex', 'flex-col', 'py-3', 'border-b', 'border-grey-off', 'sm:flex-row'];
            }

            return ['bg-blue-gradient-30', 'shadow', 'curved', 'rounded-lg', 'overflow-hidden', 'mb-4', 'md:h-full', 'flex', 'flex-col'];
        },

        imageClasses() {
            if (this.layout === 'list') {
                return ['w-full', 'mb-2', 'sm:w-1/2', 'sm:mr-2', 'sm:mb-0', 'lg:w-1/4'];
            }

            return ['w-full'];
        },

        textClasses() {
            if (this.layout === 'list') {
                return ['flex-1', 'flex', 'flex-col'];
            }

            return ['flex-1', 'flex', 'flex-col', 'p-2'];
        },

        headerClasses() {
            if (this.layout === 'list') {
                return ['text-2xl', 'text-blue', 'hover:text-grey-dark', 'transition-color', 'font-semibold', 'font-coeliac', 'leading-tight']
            }

            return ['text-2xl', 'text-black', 'hover:text-grey-dark', 'transition-color', 'text-semibold', 'leading-tight', 'text-center', 'mb-1'];
        }
    },
}
</script>
