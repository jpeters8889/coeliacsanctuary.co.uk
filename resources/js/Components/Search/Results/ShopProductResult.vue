<template>
    <div class="flex flex-col p-2 xs:flex-row">
        <div class="mb-2 xs:mb-0 xs:mr-2 xs:w-1/6">
            <img :data-src="result.image" :src="lazyLoadSrc" loading="lazy" class="lazy" :alt="result.title"/>
        </div>
        <div class="flex-1 flex flex-col">
            <h2 class="text-blue font-semibold mb-2">
                <a :href="result.link">
                    Shop Product - {{ result.title }}
                </a>
            </h2>
            <p class="text-sm">{{ result.description }}</p>
        </div>
    </div>
</template>

<script>
import SearchComponent from "@/Mixins/SearchComponent";
import LazyLoadsImages from "@/Mixins/LazyLoadsImages";

export default {
    mixins: [SearchComponent, LazyLoadsImages],
}
</script>
