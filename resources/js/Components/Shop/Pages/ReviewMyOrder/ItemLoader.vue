<template>
  <div class="flex flex-col space-y-3 md:flex-row md:space-y-0 md:space-x-3">
    <div class="flex space-x-3 md:w-1/4 md:max-w-[250px] ">
      <div class="w-1/4 max-w-[250px] flex-shrink-0 md:w-full">
        <div class="h-[4rem] bg-blue-lightest animate-pulse xs:h-[5rem] md:h-[7rem]" />
      </div>

      <div class="flex-1 md:hidden">
        <div class="bg-blue-dark bg-opacity-50 h-[1.5rem] w-[80%] animate-pulse" />
      </div>
    </div>

    <div class="flex-1">
      <div class="hidden md:block mb-2">
        <div class="bg-blue-dark bg-opacity-50 h-[1.5rem] w-[80%] animate-pulse" />
      </div>

      <div class="flex flex-col mb-3">
        <div class="h-[0.8rem] bg-grey-dark bg-opacity-30 mb-1 animate-pulse xs:h-[1rem]" />

        <div class="flex space-x-2">
          <div class="h-[1.3rem] w-1/3 bg-grey-dark bg-opacity-30 animate-pulse sm:h-[1.5rem]" />

          <div class="h-[1.3rem] w-2/3 bg-yellow bg-opacity-30 animate-pulse sm:h-[1.5rem]" />
        </div>
      </div>

      <div class="flex flex-col">
        <div class="h-[0.8rem] bg-grey-dark bg-opacity-30 mb-1 animate-pulse xs:h-[1rem]" />

        <div class="bg-grey-lightest border border-grey-off p-1 rounded h-[6rem] mt-3 animate-pulse md:h-[4rem]">
          <div class="h-[1rem] bg-grey-dark bg-opacity-30 animate-pulse w-20 animate-pulse" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  //
};
</script>
