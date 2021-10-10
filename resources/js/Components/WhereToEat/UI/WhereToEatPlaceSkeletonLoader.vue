<template functional>
  <div class="flex flex-col p-3 bg-white m-2 lg:mt-0 lg:mr-0">
    <div class="w-full flex animate-pulse">
      <div class="w-full flex flex-col sm:w-3/5 lg:w-2/3">
        <div class="flex justify-between">
          <div class="flex-1 mb-4 flex flex-col space-y-1 pr-2">
            <h2 class="h-5 bg-black bg-opacity-30" />
            <h3 class="bg-grey-darker h-4 w-3/4 bg-opacity-30" />
            <span class="bg-grey h-3 w-1/5 bg-opacity-30" />
          </div>

          <div class="w-6 h-6 bg-blue bg-opacity-30 xs:w-7 xs:h-7" />
        </div>

        <div class="w-full flex flex-col sm:flex-row">
          <div class="w-full flex flex-col space-y-3">
            <div class="flex flex-col space-y-1">
              <p class="bg-grey w-11/12 h-3 bg-opacity-30" />
              <p class="bg-grey w-1/2 h-3 bg-opacity-30" />
              <p class="bg-grey w-56 h-3 bg-opacity-30" />
            </div>

            <div class="flex flex-col mt-2 font-semibold space-y-1">
              <span class="block bg-grey-dark w-9/12 h-3 bg-opacity-30" />
              <span class="block bg-grey-dark w-1/3 h-3 bg-opacity-30" />
              <span class="block bg-grey-dark w-1/5 h-3 bg-opacity-30" />
            </div>
          </div>
        </div>
      </div>

      <div class="hidden sm:block pl-4 sm:w-2/5 lg:w-1/3">
        <div class="min-h-map-small sm:min-h-map w-full bg-gradient-to-b from-grey-off to-grey-off-light" />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  //
};
</script>
