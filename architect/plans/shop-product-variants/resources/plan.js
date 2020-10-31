import PlanList from "./Components/PlanList";
import PlanForm from "./Components/PlanForm";

Architect.onBoot((Vue) => {
   Vue.component('shop-product-variants-list', PlanList);
   Vue.component('shop-product-variants-form', PlanForm);
});
