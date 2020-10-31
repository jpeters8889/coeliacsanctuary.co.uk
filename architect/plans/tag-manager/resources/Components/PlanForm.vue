<template>
    <div>
        <div class="form-control form-control-input flex flex-wrap">
            <input type="hidden" :value="allTags.join(',')" />

            <ul class="flex flex-wrap">
                <li v-for="tag in allTags" class="mr-1 mb-1 bg-blue-900 rounded text-white font-semibold text-sm flex">
                    <span class="border-r-1 border-white-20 flex-1 py-1 px-2">{{ tag }}</span>
                    <span @click="removeTag(tag)" class="text-white-20 cursor-pointer hover:text-white py-1 px-2">
                    <font-awesome-icon :icon="['fas', 'times']"></font-awesome-icon>
                </span>
                </li>
            </ul>

            <input type="text"
                   class="border-0 p-0 m-0"
                   @keyup="searchTag"
                   v-on:keyup.enter.prevent="pushTag()"
                   v-model="searchTerm"
                   placeholder="Add Tag..." />
        </div>

        <div :class="searchResultsDisplay" class="relative">
            <ul class="absolute bg-blue-200 w-auto b-1 border-blue-500 shadow">
                <li class="flex justify-between p-2 border-b-1 border-black-50 cursor-pointer hover:bg-black-10"
                    v-for="result in searchResults"
                    @click="pushTag(result)"
                >
                    {{ result }}
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    import {IsAFormField} from 'architect-js-helpers';

    export default {
        mixins: [IsAFormField],

        data: () => ({
            allTags: [],
            searchResultsDisplay: 'hidden',
            searchResults: [],
            searchTerm: '',
        }),

        mounted() {
            if (this.value) {
                this.allTags = this.value.split(',');
            }
        },

        methods: {
            removeTag(tag) {
                this.allTags = this.allTags.filter(tags => tags !== tag);
            },

            searchTag() {
                if (this.searchTerm === '') {
                    return;
                }

                if (this.searchTerm.substr(-1) === ',') {
                    this.pushTag(this.searchTerm);
                    return;
                }

                window.Architect.request().post('/external/tag-manager/search', {
                    searchTerm: this.searchTerm,
                    tagSource: this.metas.tagSource,
                })
                    .then((response) => {
                        this.searchResults = response.data;
                        this.searchResultsDisplay = 'block';
                    })
            },

            pushTag(tag = '') {
                if (tag === '') {
                    tag = this.searchTerm;
                }

                this.allTags.push(tag.replace(',', ''));

                this.closeTagSearch();
            },

            closeTagSearch() {
                this.searchTerm = '';
                this.searchResults = [];
                this.searchResultsDisplay = 'hidden';
            },

            getFormData() {
                return {
                    name: this.name,
                    value: this.allTags.join(','),
                }
            }
        }
    }
</script>
