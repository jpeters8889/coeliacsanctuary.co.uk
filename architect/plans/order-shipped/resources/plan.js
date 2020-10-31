import PlanList from "./Components/PlanList";
import PlanForm from "./Components/PlanForm";

Architect.onBoot((Vue) => {
   Vue.component('order-shipped-list', PlanList);
   Vue.component('order-shipped-form', PlanForm);
});
