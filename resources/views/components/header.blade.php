<header class="w-full">
    <div class="w-full bg-blue flex justify-between items-center px-2 py-0 text-white text-3xl">
        <global-layout-mobile-nav class="mr-2"></global-layout-mobile-nav>
        <global-layout-coeliac-icon class="text-white xs:hidden" style="height: 1.875rem"></global-layout-coeliac-icon>
        <search-ui-header></search-ui-header>
    </div>

    <div class="w-full bg-blue-light border-yellow border-b-4 mb-2 p-3">
        <div class="wrapper">
            <div class="flex">
                <div class="hidden xs:block w-1/5 mr-1">
                    <a href="/" title="Back Home!">
                        <img src="{{ asset('assets/svg/logo.svg') }}" alt="Sealiac the Seal!" />
                    </a>
                </div>
                <div class="text-center xs:text-left w-full">
                    <h1 class="text-3xl font-coeliac mb-1">Coeliac Sanctuary</h1>
                    <h2 class="font-thin">Gluten Free Eateries, Blogs, Recipes, Reviews & more</h2>
                </div>
            </div>
            <div class="flex w-full justify-center text-3xl text-white">
                <a href="" class="mx-2" target="_blank">
                    <font-awesome-icon :icon="['fab', 'facebook-square']"></font-awesome-icon>
                </a>
                <a href="" class="mx-2" target="_blank">
                    <font-awesome-icon :icon="['fab', 'twitter-square']"></font-awesome-icon>
                </a>
                <a href="" class="mx-2" target="_blank">
                    <font-awesome-icon :icon="['fab', 'instagram']"></font-awesome-icon>
                </a>
                <a href="" class="mx-2" target="_blank">
                    <font-awesome-icon :icon="['fab', 'pinterest-square']"></font-awesome-icon>
                </a>
            </div>
        </div>
    </div>
</header>
