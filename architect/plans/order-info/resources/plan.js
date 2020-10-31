import PlanList from "./Components/PlanList";
import PlanForm from "./Components/PlanForm";

Architect.onBoot((Vue) => {
   Vue.component('order-info-list', PlanList);
   Vue.component('order-info-form', PlanForm);
});
