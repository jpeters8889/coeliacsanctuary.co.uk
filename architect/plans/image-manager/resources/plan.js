import PlanList from "./Components/PlanList";
import PlanForm from "./Components/PlanForm";

Architect.onBoot((Vue) => {
   Vue.component('image-manager-list', PlanList);
   Vue.component('image-manager-form', PlanForm);
});
