<div class="page-box p-3 shadow flex flex-col space-y-4 sm:flex-row sm:space-x-6 lg:flex-col xl:flex-row lg:space-x-0 lg:p-6 xl:space-x-6">
    <div class="flex justify-center items-center m-12 text-blue sm:m-0 sm:p-4 sm:pr-0 sm:w-1/4 sm:flex-shrink-0 lg:p-0 lg:mb-4 lg:w-1/2 lg:mx-auto xl:w-1/4 lg:m-0">
        {{ $icon }}
    </div>

    <div class="flex flex-col space-y-4 sm:w-3/4 lg:w-full xl:w-3/4">
        <h3 class="text-2xl text-blue font-semibold text-center sm:text-left sm:-mt-4 lg:text-center xl:text-left">
            {{ $title }}
        </h3>

        <p>{{ $body }}</p>
    </div>
</div>
