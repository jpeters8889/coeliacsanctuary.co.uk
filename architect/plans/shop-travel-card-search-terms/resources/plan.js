import PlanList from "./Components/PlanList";
import PlanForm from "./Components/PlanForm";

Architect.onBoot((Vue) => {
   Vue.component('shop-travel-card-search-terms-list', PlanList);
   Vue.component('shop-travel-card-search-terms-form', PlanForm);
});
