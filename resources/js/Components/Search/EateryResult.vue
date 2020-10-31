<template>
    <div class="flex flex-col p-2 xs:flex-row">
        <div class="mb-2 xs:mb-0 xs:mr-2 xs:w-1/6">
            <static-map :lat="result.lat" :lng="result.lng" :mapClasses="['h-48 xs:h-16']"></static-map>
        </div>
        <div class="flex-1 flex flex-col">
            <h2 class="text-blue font-semibold mb-2">
                <a :href="result.link">
                    Eatery - {{ result.title }}, {{ result.town }}, {{ result.county }}
                </a>
            </h2>
            <p class="text-sm">{{ result.description}}</p>
        </div>
    </div>
</template>

<script>
    import SearchComponent from "../../Mixins/SearchComponent";

    export default {
        mixins: [SearchComponent],
    }
</script>
