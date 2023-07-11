import PlanList from "./Components/PlanList";
import PlanForm from "./Components/PlanForm";

Architect.onBoot((Vue) => {
   Vue.component('wte-nationwide-branches-list', PlanList);
   Vue.component('wte-nationwide-branches-form', PlanForm);
});
