import PlanList from "./Components/PlanList";
import PlanForm from "./Components/PlanForm";

Architect.onBoot((Vue) => {
   Vue.component('order-dispatch-slip-list', PlanList);
   Vue.component('order-dispatch-slip-form', PlanForm);
});
