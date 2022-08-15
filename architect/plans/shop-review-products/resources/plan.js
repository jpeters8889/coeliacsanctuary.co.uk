import PlanList from "./Components/PlanList";
import PlanForm from "./Components/PlanForm";

Architect.onBoot((Vue) => {
   Vue.component('shop-review-products-list', PlanList);
   Vue.component('shop-review-products-form', PlanForm);
});
