<footer class="bg-gradient-to-br from-blue to-blue-light p-3 mt-4 lg:pt-8">
    <div class="inner-wrapper flex flex-col">
        <div class="w-5/6 mx-auto lg:w-4/5">
            <h4 class="font-medium text-center mb-2">Enter your email address below to get our newsletter sent straight
                to your inbox!</h4>
            <global-layout-footer-newsletter></global-layout-footer-newsletter>
        </div>

        <global-ui-google-ad code="3102132022"></global-ui-google-ad>

        <div class="mt-6 flex flex-col justify-center items-center sm:flex-row sm:items-start lg:mt-10">
            <div class="flex flex-col sm:w-1/2 sm:mr-3 lg:w-3/5">
                <div class="flex items-center justify-center sm:justify-start">
                    <global-layout-coeliac-icon colour='#000' class="text-black mr-1" style="height: 1.25rem"></global-layout-coeliac-icon>
                    <h2 class="text-black text-xl font-semibold">Coeliac Sanctuary</h2>
                </div>
                <p class="text-sm leading-tight mt-1 text-center sm:text-left">
                    Coeliac Sanctuary, more than a gluten free blog, find gluten free, coeliac safe places to eat,
                    gluten free recipes, blogs, reviews, buy coeliac travel cards and more!
                </p>
            </div>

            <div class="mt-4 sm:w-1/2 sm:m-0 lg:w-2/5">
                <ul class="flex flex-wrap text-base text-center sm:text-left">
                    <li class="w-1/2">
                        <a class="hover:font-medium" href="/shop">Shop</a>
                    </li>
                    <li class="w-1/2">
                        <a class="hover:font-medium" href="/blog">Blogs</a>
                    </li>
                    <li class="w-1/2">
                        <a class="hover:font-medium" href="/wheretoeat">Places to Eat</a>
                    </li>
                    <li class="w-1/2">
                        <a class="hover:font-medium" href="/recipe">Recipes</a>
                    </li>
                    <li class="w-1/2">
                        <contact-trigger class="cursor-pointer hover:font-medium">Contact Us</contact-trigger>
                    </li>
                </ul>
            </div>
        </div>

        <div class="mt-4 pt-2 border-t border-white border-opacity-50 text-center text-sm w-11/12 mx-auto">
            <p>
                Copyright &copy; 2014 - {{ date('Y') }} Coeliac Sanctuary
            </p>
            <div>
                <a class="font-medium hover:underline" href="/terms-of-use">Terms of Use</a> |
                <a class="font-medium hover:underline" href="/privacy-policy">Privacy Policy</a> |
                <a class="font-medium hover:underline" href="/cookie-policy">Cookie Policy</a> |
{{--                <a class="font-medium hover:underline" href="/site-map">Site Map</a> |--}}
                <a class="font-medium hover:underline" href="/work-with-us">Work With Us</a>
            </div>
        </div>
    </div>
</footer>
