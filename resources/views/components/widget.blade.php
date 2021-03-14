<div {{ $attributes->merge(['class' => 'p-2 page-box flex flex-col shadow']) }}>
    @isset($title)
        <h3 class="text-lg leading-tight mb-2">
            {{ $title }}
        </h3>
    @endisset

   {{ $slot }}
</div>
