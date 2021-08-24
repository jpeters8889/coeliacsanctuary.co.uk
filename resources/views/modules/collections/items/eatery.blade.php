<div class="flex flex-col sm:flex-row">
    <div class="flex flex-col mb-2 sm:mb-0 sm:mr-2 sm:w-1/4">
        <map-static :lat="{{ $eatery->lat }}" :lng="{{ $eatery->lng }}" :map-classes="['h-400 sm:h-200']"></map-static>
    </div>

    <div class="p-2 flex flex-col sm:flex-1 sm:py-0">
        <h2
            class="text-2xl text-blue-darkest transition-all font-semibold font-coeliac leading-tight">
            {{ $eatery->name }} -
            <a class="text-blue-dark hover:text-grey-dark" target="_blank"
               href="/wheretoeat/{{ $eatery->county->slug }}/{{ $eatery->town->slug }}">{{ $eatery->town->town }}</a>,
            <a class="text-blue-dark hover:text-grey-dark" target="_blank"
               href="{{ $eatery->county->slug }}">{{ $eatery->county->county }}</a>
        </h2>

        <p class="flex-1">{{ $description }}</p>

        <div class="flex justify-between">
            <p class="text-xs mt-2">
                View more places in
                <a class="text-blue-dark font-semibold hover:text-black" target="_blank"
                   href="/wheretoeat/{{ $eatery->county->slug }}/{{ $eatery->town->slug }}">{{ $eatery->town->town }}</a>,
                <a class="text-blue-dark font-semibold hover:text-black" target="_blank"
                   href="{{ $eatery->county->slug }}">{{ $eatery->county->county }}</a>
            </p>
            <a class="py-1 px-2 rounded-lg font-semibold bg-gradient-to-br from-blue/30 to-blue-light/30 text-xs" target="_blank"
               href="/wheretoeat">
                Place to Eat
            </a>
        </div>
    </div>
</div>
