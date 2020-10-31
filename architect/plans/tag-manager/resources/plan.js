import PlanList from "./Components/PlanList";
import PlanForm from "./Components/PlanForm";

Architect.onBoot((Vue) => {
   Vue.component('tag-manager-list', PlanList);
   Vue.component('tag-manager-form', PlanForm);
});
