<template>
    <div class="hidden xs:block">
        <div id="breadcrumb"
             class="my-2 border-grey-off border bg-grey-off-light p-2 leading-none"
             :class="sticky ? 'fixed top-50px slide-down w-full mt-1 z-20' : ''">
            <div class="leading-none inner-wrapper flex flex-col sm:flex-row sm:items-center" :style="sticky ? 'max-width: 1500px;' : ''">
                <div class="flex-1 flex-col flex justify-center flex-wrap mb-2 sm:flex-no-wrap sm:flex-row sm:items-center sm:justify-start sm:m-0 sm:pr-3">
                    <div class="font-thin text-center sm:pr-1">
                        You're here:
                    </div>
                    <div class="flex flex-wrap my-1 justify-center">
                        <div v-for="crumb in crumbs"
                             class="text-grey-dark font-medium flex justify-start items-center p-1 sm:w-full lg:w-auto">
                        <span class="flex-1">
                            <a :href="crumb.link" class="hover:underline">{{ crumb.title }}</a>
                        </span>
                            <span class="text-left pl-1">
                            <font-awesome-icon :icon="['fas', 'angle-double-right']"></font-awesome-icon>
                        </span>
                        </div>
                    </div>
                    <div class="font-medium text-center">
                        {{ location }}
                    </div>
                </div>

                <div class="flex justify-center">
                    <div class="mr-2 text-3xl text-grey cursor-pointer hover:text-social-facebook transition-color"
                         @click.prevent="facebookShare()">
                        <font-awesome-icon :icon="['fab', 'facebook-square']"></font-awesome-icon>
                    </div>

                    <div class="mr-2 text-3xl text-grey cursor-pointer hover:text-social-twitter transition-color"
                         @click.prevent="twitterShare()">
                        <font-awesome-icon :icon="['fab', 'twitter-square']"></font-awesome-icon>
                    </div>

                    <div class="mr-2 text-3xl text-grey cursor-pointer hover:text-social-pinterest transition-color"
                         @click.prevent="pinterestShare()">
                        <font-awesome-icon :icon="['fab', 'pinterest-square']"></font-awesome-icon>
                    </div>

                    <div class="text-3xl text-grey cursor-pointer hover:text-social-reddit transition-color"
                         @click.prevent="redditShare()">
                        <font-awesome-icon :icon="['fab', 'reddit-square']"></font-awesome-icon>
                    </div>
                </div>
            </div>
        </div>
        <div id="breadcrumb-check"></div>
    </div>
</template>

<script>

    import GoogleEvents from "../Mixins/GoogleEvents";

    export default {
        mixins: [GoogleEvents],

        props: {
            location: {
                required: true,
                type: String,
            },
            crumbs: {
                required: true,
                type: Array,
            }
        },

        data: () => ({
            sticky: false,
        }),

        mounted() {
            new IntersectionObserver(entries => {
                this.sticky = entries[0].intersectionRatio === 0;
            }).observe(document.querySelector('#breadcrumb-check'));
        },

        methods: {
            facebookShare() {
                this.googleEvent('event', 'share', {
                    event_label: 'facebook',
                });

                this.openPopup(
                    'https://www.facebook.com/sharer.php?u=' + window.location.href,
                    'Share On Facebook'
                );
            },

            twitterShare() {
                this.googleEvent('event', 'share', {
                    event_label: 'twitter',
                });

                this.openPopup(
                    'https://twitter.com/intent/tweet?text=' + document.querySelector('meta[name=description').getAttribute('content') + '&via=CoeliacSanc&url=' + window.location.href,
                    'Share on Twitter'
                );
            },

            pinterestShare() {
                this.googleEvent('event', 'share', {
                    event_label: 'pinterest',
                });

                this.openPopup(
                    'https://www.pinterest.com/pin/create/button/?url=' + window.location.href + '&media=' + document.querySelector('meta[property="og:image"]').getAttribute('content') + '&description=' + document.querySelector('meta[name=description').getAttribute('content'),
                    'Share on Pinterest'
                );
            },

            redditShare() {
                this.googleEvent('event', 'share', {
                    event_label: 'reddit',
                });

                this.openPopup(
                    'http://www.reddit.com/submit?url=' + window.location.href + '&title=' + document.querySelector('title').innerText,
                    'Share on Reddit'
                );
            },

            openPopup(link, title) {
                window.open(link, title, 'height=480,width=640,toolbar=no,menubar=no,scrollbars=no,resizable=no,location=no,directories=no,status=no')
            }
        }
    }
</script>
