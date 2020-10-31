import PlanList from "./Components/PlanList";
import PlanForm from "./Components/PlanForm";

Architect.onBoot((Vue) => {
   Vue.component('coeliac-shop-order-items-list', PlanList);
   Vue.component('coeliac-shop-order-items-form', PlanForm);
});
