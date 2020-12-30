import PlanList from "./Components/PlanList";
import PlanForm from "./Components/PlanForm";

Architect.onBoot((Vue) => {
   Vue.component('collection-items-list', PlanList);
   Vue.component('collection-items-form', PlanForm);
});
