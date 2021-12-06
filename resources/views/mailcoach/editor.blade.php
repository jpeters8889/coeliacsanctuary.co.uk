<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.20.0/axios.min.js"></script>

<style>
    .p-1 {
        padding: .25rem;
    }

    .w-1\/2 {
        width: 50%;
    }

    .w-1\/3 {
        width: 33.33%;
    }
</style>

<div id="mailcoach">
    <div class="flex flex-col">
        <input type="hidden" name="html" v-model="renderedHtml" />
        <input type="hidden" name="structured_html" v-model="structuredData" />

        <div>
            <h2 class="text-xl mb-2">Introductory Text</h2>
            <textarea class="p-2 border border-gray-500 w-full" rows="15" v-model="introText"></textarea>
        </div>

        <div class="mt-2">
            <h2 class="text-xl mb-2">Recipes</h2>
            <div class="flex justify-between -mx-2">
                <div v-for="(recipe, index) in recipes" class="w-1/3 p-2">
                    <div v-if="!recipe" class="relative">
                        <input class="p-1 border border-gray-300 w-full" type="text" v-model="recipeSearch[index]"
                               placeholder="Search recipe..." @keyup="searchRecipe(index)"/>

                        <ul v-if="recipeResults[index].length > 0"
                            class="absolute border border-gray-500 shadow w-full bg-white z-50">
                            <li v-for="result in recipeResults[index]" @click="selectRecipe(result, index)"
                                class="p-2 border-b border-gray-300 hover:bg-grey-200">
                                @{{ result.title }}
                            </li>
                        </ul>
                    </div>
                    <div v-else class="flex flex-col">
                        <img :src="recipe.square_image || recipe.main_image" class="mb-2"/>
                        <h3 class="font-semibold">@{{ recipe.title }}</h3>
                        <p>@{{ recipe.meta_description }}</p>
                        <p class="text-sm mt-2 text-gray-400 font-semibold cursor-pointer" @click="removeRecipe(index)">
                            Remove
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-2">
            <h2 class="text-xl mb-2">Blogs</h2>
            <div class="flex justify-between -mx-2">
                <div v-for="(blog, index) in blogs" class="w-1/2 p-2">
                    <div v-if="!blog" class="relative">
                        <input class="p-1 border border-gray-300 w-full" type="text" v-model="blogSearch[index]"
                               placeholder="Search blog..." @keyup="searchBlog(index)"/>

                        <ul v-if="blogResults[index].length > 0"
                            class="absolute border border-gray-500 shadow w-full bg-white z-50">
                            <li v-for="result in blogResults[index]" @click="selectBlog(result, index)"
                                class="p-2 border-b border-gray-300 hover:bg-grey-200">
                                @{{ result.title }}
                            </li>
                        </ul>
                    </div>
                    <div v-else class="flex flex-col">
                        <img :src="blog.main_image" class="mb-2"/>
                        <h3 class="font-semibold">@{{ blog.title }}</h3>
                        <p>@{{ blog.meta_description }}</p>
                        <p class="text-sm mt-2 text-gray-400 font-semibold cursor-pointer" @click="removeBlog(index)">
                            Remove
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-2">
            <h2 class="text-xl mb-2">Reviews</h2>
            <div class="flex justify-between -mx-2">
                <div v-for="(review, index) in reviews" class="w-1/2 p-2">
                    <div v-if="!review" class="relative">
                        <input class="p-1 border border-gray-300 w-full" type="text" v-model="reviewSearch[index]"
                               placeholder="Search review..." @keyup="searchReview(index)"/>

                        <ul v-if="reviewResults[index].length > 0"
                            class="absolute border border-gray-500 shadow w-full bg-white z-50">
                            <li v-for="result in reviewResults[index]" @click="selectReview(result, index)"
                                class="p-2 border-b border-gray-300 hover:bg-grey-200">
                                @{{ result.architect_title }}
                            </li>
                        </ul>
                    </div>
                    <div v-else class="flex flex-col">
                        <img :src="review.main_image" class="mb-2"/>
                        <h3 class="font-semibold">@{{ review.architect_title }}</h3>
                        <p>@{{ review.meta_description }}</p>
                        <p class="text-sm mt-2 text-gray-400 font-semibold cursor-pointer" @click="removeReview(index)">
                            Remove
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex mt-4" style="justify-content: space-around;">
            <button
                class="link-icon bg-blue-400 text-white p-2 rounded no-underline hover:bg-blue-500 transition-all"
                @click.prevent="preview()">
                <span class="icon-label">
                    <i class="fas fa-fw fa-eye"></i>

                    <span class="icon-label-text no-underline">
                        Preview
                    </span>
                </span>
            </button>

            <button
                class="link-icon bg-blue-400 text-white p-2 rounded no-underline hover:bg-blue-500 transition-alls" @click.prevent="save($event)">
                <span class="icon-label">
                    <i class="fas fa-fw fa-code"></i>

                    <span class="icon-label-text no-underline">
                        Save Template
                    </span>
                </span>
            </button>
        </div>
    </div>

    <template v-if="showPreviewModal">
        <div class="modal-backdrop" data-modal-backdrop>
            <div class="modal-wrapper modal-wrapper-lg">
                <button class="modal-close" tabindex="-1" @click="showPreviewModal = false">
                    <i class="fas fa-times"></i>
                </button>
                <div class="modal">
                    <header class="modal-header">
                        <span class="modal-title">Preview Newsletter</span>
                    </header>
                    <div class="modal-content scrollbar">
                        <iframe class="absolute" width="100%" height="100%" :srcdoc="renderedHtml"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>

<script>
    var app = new Vue({
        el: '#mailcoach',
        data: {
            introText: @json($introText),

            recipes: @json($recipes),
            recipeSearch: ['', '', ''],
            recipeResults: [[], [], []],

            blogs: @json($blogs),
            blogSearch: ['', ''],
            blogResults: [[], []],

            reviews: @json($reviews),
            reviewSearch: ['', ''],
            reviewResults: [[], []],

            renderedHtml: @json($html),
            structuredData: @json($data),

            showPreviewModal: false,
        },

        methods: {
            selectRecipe(recipe, index) {
                this.$set(this.recipeResults, index, []);
                this.$set(this.recipeSearch, index, '');
                this.$set(this.recipes, index, recipe);
            },

            removeRecipe(index) {
                this.$set(this.recipes, index, null);
            },

            searchRecipe(index) {
                this.$set(this.recipeResults, index, []);

                axios.get('/api/recipes/?search=' + this.recipeSearch[index]).then((response) => {
                    this.$set(this.recipeResults, index, response.data.data.data);
                });
            },

            selectBlog(blog, index) {
                this.$set(this.blogResults, index, []);
                this.$set(this.blogSearch, index, '');
                this.$set(this.blogs, index, blog);
            },

            removeBlog(index) {
                this.$set(this.blogs, index, null);
            },

            searchBlog(index) {
                this.$set(this.blogResults, index, []);

                axios.get('/api/blogs/?search=' + this.blogSearch[index]).then((response) => {
                    this.$set(this.blogResults, index, response.data.data.data);
                });
            },

            selectReview(review, index) {
                this.$set(this.reviewResults, index, []);
                this.$set(this.reviewSearch, index, '');
                this.$set(this.reviews, index, review);
            },

            removeReview(index) {
                this.$set(this.reviews, index, null);
            },

            searchReview(index) {
                this.$set(this.reviewResults, index, []);

                axios.get('/api/reviews/?search=' + this.reviewSearch[index]).then((response) => {
                    this.$set(this.reviewResults, index, response.data.data.data);
                });
            },

            render(then = null) {
                const checks = [
                    this.introText === '',
                    this.recipes.includes(null),
                    this.blogs.includes(null),
                    this.reviews.includes(null),
                ];

                if (checks.includes(true)) {
                    alert('Please complete all sections');
                    return false;
                }

                const params = {
                    introText: this.introText,
                    recipes: this.recipes.map(recipe => recipe.id),
                    blogs: this.blogs.map(blog => blog.id),
                    reviews: this.reviews.map(review => review.id),
                };

                this.renderedHtml = null;
                this.structuredData = JSON.stringify(params);

                axios.post('/api/newsletter/render-mjml', {
                    _token: '{{ csrf_token() }}',
                    ... params,
                }).then((response) => {
                    this.renderedHtml = response.data;

                    if (then) {
                        then();
                    }
                });
            },

            preview() {
                this.render(() => this.showPreviewModal = true);
            },

            save($event) {
                this.render(() => $event.target.closest('form').submit())
            }
        }
    })
</script>
