<template>
    <div class="top-0 left-0 flex justify-center items-center w-full h-full z-max"
         :class="[background, backgroundPosition]"
         v-show="show">
        <div class="rounded-full spin"
             :class="fadedBorderColor"
             :style="loaderStyles">
        </div>
    </div>
</template>

<script>
export default {
    props: {
        show: {
            type: Boolean,
            default: false
        },
        width: {
            type: String,
            default: '50%',
        },
        height: {
            type: String,
            default: '50%',
        },
        maxWidth: {
            type: String,
            default: '50px',
        },
        maxHeight: {
            type: String,
            default: '50px',
        },
        background: {
            type: String,
            default: 'bg-transparent',
        },
        fadedBorderColor: {
            type: String,
            default: 'border-blue-20',
        },
        primaryBorderColor: {
            type: String,
            default: '#80CCFC',
        },
        backgroundPosition: {
            type: String,
            default: 'absolute',
        },
        borderWidth: {
            type: String,
            default: '5px',
        },
    },

    computed: {
        loaderStyles() {
            return {
                borderTopColor: this.primaryBorderColor,
                borderWidth: this.borderWidth,
                width: this.width,
                height: this.height,
                maxWidth: this.maxWidth,
                maxHeight: this.maxHeight,
            }
        }
    }
}
</script>
