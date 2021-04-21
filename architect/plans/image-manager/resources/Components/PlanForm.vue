<template>
    <div>
        <div class="form-control">
            <input type="file" class="hidden" ref="fileTrigger" accept="image/*" multiple @change="processImages"/>

            <ul class="flex flex-wrap align-start">
                <li class="mr-2 mb-2 border-1 border-blue-500 rounded w-imageManager relative flex justify-center items-center text-6xl text-blue-500 cursor-pointer max-h-imageManager"
                    :class="images.length > 0 ? 'initial' : 'hidden'"
                    v-for="image in images"
                >
                    <div v-if="image.processing">
                        <font-awesome-icon :icon="['fas', 'circle-notch']" spin></font-awesome-icon>
                    </div>

                    <div v-else>
                        <img :src="'/'+image.path" alt=""/>

                        <div class="absolute left-0 bottom-0 m-1 flex flex-wrap">
                            <div v-for="(display, button) in metas.buttons"
                                 v-if="display && canDisplayButton(button,image)"
                                 class="rounded text-sm w-auto cursor-pointer mr-1 p-1"
                                 :class="generateButtonClass(button, image)"
                                 @click="handleImageButtonClick(button, image)"
                                 v-tooltip.bottom="generateButtonTooltip(button)"
                            >
                                <font-awesome-icon :icon="generateButtonIcon(button)"></font-awesome-icon>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="mr-2 mb-2 border-1 border-blue-500 rounded min-w-imageManager relative flex justify-center items-center text-6xl text-blue-500 cursor-pointer h-imageManager"
                    @click="uploadImage"
                >
                    <font-awesome-icon :icon="['fas', 'plus']"></font-awesome-icon>
                </li>
            </ul>
        </div>

        <portal to="modal" v-if="showModal">
            <modal title="Insert Image">
                <div class="w-full flex flex-col justify-center items-center leading-none">
                    <div class="w-full py-3">
                        <select class="form-control form-control-input w-full" v-model="insertType">
                            <option disabled>Image Type</option>
                            <option value='left'>Left Align</option>
                            <option value='right'>Right Align</option>
                            <option value='fullwidth'>Full Width</option>
                        </select>
                    </div>

                    <div class="w-full py-3">
                        <textarea class="form-control form-control-input w-full" placeholder="Description"
                                  v-model="insertDescription"></textarea>
                    </div>

                    <div class="w-full py-3 flex justify-center">
                        <button class="button-primary button px-4 py-1 rounded" @click.prevent="processImageInsert()">
                            Insert Image
                        </button>
                    </div>
                </div>
            </modal>
        </portal>
    </div>
</template>

<script>
import {IsAFormField} from 'architect-js-helpers';

export default {
    mixins: [IsAFormField],

    data: () => ({
        images: [],
        selectedImages: {},
        hasImages: {},
        showModal: false,

        insertType: 'left',
        insertDescription: '',
        insertImage: '',
    }),

    mounted() {
        Architect.$on('modal-close', () => {
            this.showModal = false;
        });

        Object.keys(this.metas.buttons).forEach((button) => {
            if (this.metas.buttons[button] === true) {
                if (!button === 'insert') {
                    this.$set(this.selectedImages, button, '');
                    this.$set(this.hasImages, button, false);
                }
            }
        });

        this.$set(this.selectedImages, 'article', []);

        if (this.value) {
            Object.keys(this.value).forEach((index) => {
                let position = this.pushImage();
                let image = this.value[index];

                this.displayImage(image, position);

                if (image.type) {
                    image.type.split(',').forEach((type) => {
                        if (type !== 'article') {
                            this.handleImageButtonClick(type, image);
                        } else {
                            this.$set(this.selectedImages.article, this.selectedImages.article.length, image.filename);
                        }
                    });
                }
            });

            if (!this.selectedImages.header) {
                this.handleImageButtonClick('header', this.value[0]);
            }

            if (!this.selectedImages.social) {
                this.handleImageButtonClick('social', this.value[0]);
            }
        }
    },

    methods: {
        getFormData() {
            return {
                name: this.name,
                value: JSON.stringify(this.selectedImages),
            }
        },

        uploadImage() {
            this.$refs.fileTrigger.click();
        },

        processImages() {
            const files = this.$refs.fileTrigger.files;
            const data = new FormData;
            let mapping = [];

            for (let x = 0; x < files.length; x++) {
                data.append(`files[${x}]`, files[x]);
                mapping.push(this.pushImage());
            }

            window.Architect.request().post('/external/image-manager/upload', data, {'Content-Type': 'multipart/form-data'})
                .then((response) => {
                    response.data.forEach((image, index) => {
                        this.displayImage(image, mapping[index]);
                    });
                });
        },

        pushImage() {
            let location = this.images.length;
            this.$set(this.images, location, {processing: true});

            return location;
        },

        displayImage(image, index) {
            this.$set(this.images, index, {
                processing: false,
                ...image
            });

            if (!this.metas.buttons.insert) {
                this.$set(this.selectedImages.article, this.selectedImages.article.length, image.filename);
            }
        },

        handleImageButtonClick(button, image) {
            if (button === 'insert') {
                this.showModal = !this.showModal;
                this.insertImage = image.filename;
                return;
            }

            let imageText = image.filename;
            let toSelect = true;

            if (this.selectedImages[button] === image.filename) {
                imageText = '';
                toSelect = false;
            }

            this.$set(this.selectedImages, button, imageText);
            this.$set(this.hasImages, button, toSelect);

            if(!this.metas.buttons.insert && this.selectedImages.article.includes(image.filename)) {
                this.$delete(this.selectedImages.article, this.selectedImages.article.indexOf(image.filename));
            }
        },

        generateButtonClass(button, image) {
            if (this.selectedImages[button] === image.filename) {
                return 'bg-green-500 text-white';
            }

            if (this.hasImages[button] === true) {
                return 'bg-gray-200 text-gray-500';
            }

            return 'bg-blue-500 text-white';
        },

        generateButtonIcon(button) {
            switch (button) {
                case 'social':
                    return ['fab', 'facebook-square'];
                case 'header':
                    return ['fas', 'home'];
                case 'square':
                    return ['fas', 'crop'];
                case 'insert':
                    return ['fas', 'paste'];
            }
        },

        canDisplayButton(button, image) {
            switch (button) {
                case 'social':
                case 'header':
                    return image.width >= 1200
                case 'square':
                    return image.width === image.height;
            }

            return true;
        },

        generateButtonTooltip(button) {
            switch (button) {
                case 'social':
                    return 'Set as Social Image';
                case 'header':
                    return 'Set as Header Image';
                case 'square':
                    return 'Set as Square Image';
                case 'insert':
                    return 'Insert image into body';
            }
        },

        processImageInsert() {
            const text = `<article-image src="${this.insertImage}" title="${this.insertDescription}" position="${this.insertType}"></article-image>`

            window.Architect.$emit(this.metas.insertImageIntoField + '-append', text);

            this.$set(this.selectedImages.article, this.selectedImages.article.length, this.insertImage);
            this.closeModal();
        },

        closeModal() {
            this.showModal = false;
            this.insertType = 'left';
            this.insertDescription = '';
            this.insertImage = '';
        }
    }
}
</script>
