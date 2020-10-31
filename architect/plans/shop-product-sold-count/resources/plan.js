import PlanList from "./Components/PlanList";
import PlanForm from "./Components/PlanForm";

Architect.onBoot((Vue) => {
   Vue.component('shop-product-sold-count-list', PlanList);
   Vue.component('shop-product-sold-count-form', PlanForm);
});
