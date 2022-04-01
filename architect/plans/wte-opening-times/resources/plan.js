import PlanList from "./Components/PlanList";
import PlanForm from "./Components/PlanForm";

Architect.onBoot((Vue) => {
   Vue.component('wte-opening-times-list', PlanList);
   Vue.component('wte-opening-times-form', PlanForm);
});
