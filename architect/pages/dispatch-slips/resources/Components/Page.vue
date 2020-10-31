<template>
    <div class="w-full flex flex-col">
        <p class="text-lg text-red-500 font-semibold mb-2">
            Do NOT use any normal print methods, use the big button below to print the dispatch slips!! Do NOT press
            print until the red box below disappears!!
        </p>

        <button class="w-full p-2 text-3xl bg-red-500 text-white slider-bg rounded mb-2" @click="print()">
            Print
        </button>

        <iframe id="iFramePdf" :src="frameSrc" class="w-full border border-black bg-red-500"
                style="height: 800px"></iframe>
    </div>
</template>

<script>
    export default {
        props: {
            id: String,
            page: String,
        },

        methods: {
            print() {
                window.Architect.request().put('/external/coeliac-dispatch-slips/printed', {
                    id: this.id,
                }).then(() => {
                    const elem = document.getElementById('iFramePdf');

                    elem.focus();
                    elem.contentWindow.print();
                });
            }
        },

        computed: {
            frameSrc: function () {
                return '/cs-adm/api/external/coeliac-dispatch-slips/render/' + this.id;
            }
        }
    }
</script>
