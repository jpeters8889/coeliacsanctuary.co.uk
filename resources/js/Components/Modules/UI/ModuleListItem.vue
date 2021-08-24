<template>
    <div class="bg-white shadow overflow-hidden flex flex-col md:rounded-md" :class="gridClasses">
        <a class="w-full flex flex-col" :href="item.link">
            <img
                :data-src="item.main_image"
                :alt="item.title"
                loading="lazy"
                class="lazy w-full"
                :src="index > 0 ? lazyLoadSrc : item.main_image"
                v-if="module !== 'recipes'"
            />
            <global-ui-recipe-image
                :src="item.main_image"
                :alt="item.title" v-else
            />
        </a>

        <div class="flex-1 flex flex-col p-4">
            <a :href="item.link"
               class="text-2xl text-black hover:text-grey-dark transition-all text-semibold leading-tight text-center mb-2"
            >
                <h2 v-html="item.title"></h2>
            </a>

            <p class="mb-1 flex-1 h-full" v-html="description"></p>
        </div>

        <div :class="footerClasses">
            <div class="flex flex-col font-semibold transition-all mb-4 lg:mb-0">
                <template v-if="module === 'blogs'">
                    <h4 class="">Tagged With:</h4>
                    <ul class="flex flex-wrap text-xs">
                        <li v-for="tag in item.tags" class="mr-2">
                            <a class="text-blue-dark hover:text-black" :href="filteredUrl('tags', tag.slug)">
                                {{ tag.tag }}
                            </a>
                        </li>
                    </ul>
                </template>

                <template v-if="module === 'recipes'">
                    <h4 class="">This recipe is:</h4>
                    <ul class="flex flex-wrap text-xs mb-2">
                        <li v-for="feature in item.features" class="mr-2 text-blue-dark">
                            <a class="text-blue-dark hover:text-black" :href="filteredUrl('feature', feature.feature)">
                                {{ feature.feature }}
                            </a>
                        </li>
                    </ul>

                    <p class="mb-1 flex font-semibold">
                        Makes {{ item.serving_size }}<br/>
                        {{ item.nutrition.calories }} Calories per {{ item.per }}
                    </p>
                </template>

                <template v-if="module === 'reviews'">
                    <a class="font-semibold text-xs" :href="`/wheretoeat/${item.eatery.county.slug}/${item.eatery.town.slug}`">
                        {{ item.eatery.type.name }} in {{ item.eatery.town.town }}, {{ item.eatery.county.county }}
                    </a>
                    <global-ui-stars class="my-2" :stars="item.overall_rating"></global-ui-stars>
                </template>
            </div>

            <ul :class="footerMetaClasses">
                <li>Added on
                    <time :datetime="item.created_at">{{ formatDate(item.created_at) }}</time>
                </li>
                <li v-if="module !== 'collection'" v-text="commentsText(item.comments_count)"></li>
                <li v-else v-text="collectionItemsText(item.items_count)"></li>
            </ul>
        </div>
    </div>
</template>

<script>
import FormatsDates from "@/Mixins/FormatsDates";
import LazyLoadsImages from "@/Mixins/LazyLoadsImages";
import ResponsiveOptions from "@/Mixins/ResponsiveOptions";

export default {
    mixins: [FormatsDates, LazyLoadsImages, ResponsiveOptions],

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
        hasFilters: {
            type: Boolean,
            default: false,
        },
        urlPrefix: {
            type: String,
            required: true,
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
        },

        filteredUrl(filter, key) {
            return `${window.config.baseUrl}/${this.urlPrefix}?o=${btoa(`filter[${filter}]=${key}`)}`;
        }
    },

    computed: {
        description() {
            if (this.page === 1 && this.index === 0) {
                return this.item.description || this.item.meta_description;
            }

            return this.item.meta_description;
        },

        footerClasses() {
            const classes = ['text-xs', 'p-4', 'bg-grey-light', 'border-t', 'border-grey-off-light', 'flex', 'flex-col']

            if (this.isLt('md') || this.page > 1) {
                return classes;
            }

            if (this.index < 3) {
                classes.push('lg:flex-row', 'lg:justify-between')
            }

            return classes;
        },

        footerMetaClasses() {
            const classes = ['flex']

            if (this.isLt('md') || this.page > 1 || this.index >= 3) {
                classes.push('justify-between', 'mt-2');

                return classes;
            }

            classes.push('lg:flex-col', 'lg:text-right', 'lg:min-w-250')

            return classes;
        },

        gridClasses() {
            if (this.isLt('md')) {
                return;
            }

            const rtr = ['col-span-2'];

            if (this.page > 1) {
                return rtr
            }

            if (this.index === 0) {
                rtr.push('col-span-6')
            }

            if (this.index === 1 || this.index === 2) {
                rtr.push('col-span-3');
            }

            return rtr;
        }
    },
}
</script>
