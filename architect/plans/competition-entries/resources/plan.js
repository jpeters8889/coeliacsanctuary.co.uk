import PlanList from "./Components/PlanList";
import PlanForm from "./Components/PlanForm";
import Paginator from "./Components/Paginator";

Architect.onBoot((Vue) => {
   Vue.component('competition-entries-list', PlanList);
   Vue.component('competition-entries-form', PlanForm);
   Vue.component('competition-paginator', Paginator);
});
