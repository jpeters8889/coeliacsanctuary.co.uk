<template>
    <nav class="text-lg text-black h-full leading-loose w-full js-primary-nav">
        <ul class="flex relative">
            <li v-for="item in navigation" class="border-b-4 border-transparent hover:border-white-80 cursor:pointer"
                @mouseenter="hoveringOn = item.label" @mouseleave="hoveringOn = ''">
                <a class="py-2 px-4" :href="item.link">
                    {{ item.label }}
                </a>
                <div v-if="item.children" v-show="hoveringOn === item.label"
                     class="absolute z-max bg-grey-lightest p-2 w-full left-0 shadow-2xl">
                    <template v-if="item.children.layout === '3x5' || item.children.layout === '3'">
                        <div class="flex">
                            <ul class="w-3/5">
                                <li v-for="(child, index) in item.children.items" v-if="index < 3"
                                    class="py-2 mr-4 hover:bg-yellow-40 transition-bg"
                                    :class="index < 2 ? 'border-b border-yellow' : ''">
                                    <a :href="child.link" class="flex">
                                        <div class="w-1/4 mr-1 lg:w-1/6">
                                            <img :data-src="child.main_image+'?nav'" :src="lazyLoadSrc" loading="lazy" class="lazy"
                                                 :alt="child.title">
                                        </div>
                                        <div class="leading-none flex-1">
                                            <h3 class="mb-1 font-medium">{{ child.title }}</h3>
                                            <p class="text-sm">{{ child.meta_description}}</p>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                            <ul v-if="item.children.layout === '3x5'"
                                class="w-2/5 text-base leading-none flex flex-col py-2">
                                <li v-for="(child, index) in item.children.items" v-if="index >= 3" class="mb-3"
                                    :class="index === (item.children.items.length - 1) ? 'flex-1' : ''">
                                    <a :href="item.link + '/' + child.slug">{{ child.title }}</a>
                                </li>
                                <li>
                                    <link-button :href="item.link" rounded>See All {{ item.label }}</link-button>
                                </li>
                            </ul>
                        </div>
                    </template>
                    <template v-if="item.children.layout === 'list'">
                        <ul class="flex flex-wrap text-base leading-none py-2">
                            <li v-for="child in item.children.items" class="w-1/2 mb-2 hover:underline">
                                <a v-if="child.label && child.link" :href="child.link" class="block w-full">
                                    {{ child.label }}
                                </a>
                                <template v-if="child.component">
                                    <component :is="child.component" class="block w-full cursor-pointer">
                                        {{ child.label }}
                                    </component>
                                </template>
                            </li>
                        </ul>
                    </template>
                </div>
            </li>
        </ul>
    </nav>
</template>

<script>
    import LazyLoadsImages from "../Mixins/LazyLoadsImages";

    export default {
        mixins: [LazyLoadsImages],

        data: () => ({
            hoveringOn: '',
            navigation: {
                home: {
                    label: 'Home',
                    link: '/',
                    children: null,
                },
                shop: {
                    label: 'Shop',
                    link: '/shop',
                    children: null,
                },
                blogs: {
                    label: 'Blogs',
                    link: '/blog',
                    children: null,
                },
                eatingOut: {
                    label: 'Eating Out',
                    link: '/eating-out',
                    children: null,
                },
                recipes: {
                    label: 'Recipes',
                    link: '/recipe',
                    children: null,
                },
                collections: {
                    label: 'Collections',
                    link: '/collection',
                    children: null,
                },
                info: {
                    label: 'Info',
                    link: '/info',
                    children: null,
                }
            }
        }),

        mounted() {
            coeliac().request().get('/api/navigation').then((response) => {
                Object.keys(response.data).forEach((key) => {
                    if (this.navigation[key]) {
                        this.navigation[key].children = response.data[key];
                    }
                });

                if(this.navigation.collections.children === null || this.navigation.collections.children.items.length === 0) {
                    this.$root.$delete(this.navigation, 'collections')
                }

                this.loadLazyImages();
            });
        },

        watch: {
            hoveringOn: function () {
                if (Object.values(this.navigation).map(value => value.label).includes(this.hoveringOn)) {
                // if (this.hoveringOn !== '') {
                    document.querySelectorAll('img.lazy').forEach((image) => {
                        if (image.hasAttribute('data-src')) {
                            image.setAttribute('src', image.getAttribute('data-src'));
                            image.removeAttribute('data-src');
                            image.classList.remove('lazy');
                        }
                    });
                }
            }
        }
    }
</script>
