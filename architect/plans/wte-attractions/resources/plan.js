import PlanList from "./Components/PlanList";
import PlanForm from "./Components/PlanForm";

Architect.onBoot((Vue) => {
   Vue.component('wte-attractions-list', PlanList);
   Vue.component('wte-attractions-form', PlanForm);
});
