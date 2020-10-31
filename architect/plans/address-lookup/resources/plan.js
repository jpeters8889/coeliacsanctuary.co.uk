import PlanList from "./Components/PlanList";
import PlanForm from "./Components/PlanForm";

Architect.onBoot((Vue) => {
   Vue.component('address-lookup-list', PlanList);
   Vue.component('address-lookup-form', PlanForm);
});
