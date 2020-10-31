<template>
    <div>
        <widget>
            <template v-slot:title>
                Sign up to our newsletter
            </template>

            <template v-slot:body>
                <div class="flex flex-col">
                    <p class="text-sm leading-tight mb-2">
                        Enter your email address below to get our newsletter sent straight to your inbox!
                    </p>

                    <div class="w-full flex flex-row justify-center text-sm leading-none">
                        <input class="bg-grey-lightest border border-grey-off flex-1 rounded p-1 mr-1" type="email"
                               v-model="email" placeholder="Enter your email address..."/>
                        <div class="text-center">
                            <button @click="submit()"
                                class="bg-blue text-grey-lightest leading-none px-1 py-2 border border-blue rounded">
                                Subscribe!
                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </widget>

        <widget v-if="showAd" class="mt-2">
            <template v-slot:body>
                <google-ad code="7266831645"></google-ad>
            </template>
        </widget>
    </div>
</template>

<script>
    import SubscribesToNewsletter from "../../Mixins/SubscribesToNewsletter";

    export default {
        mixins: [SubscribesToNewsletter],

        props: {
            showAd: {
                type: Boolean,
                default: true,
            }
        }
    }
</script>
