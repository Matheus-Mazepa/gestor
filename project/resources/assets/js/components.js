//template

import { Breadcrumb, BreadcrumbItem } from "./components/Breadcrumb";
import { DataList } from "./components/DataList";

Vue.component("breadcrumb-item", BreadcrumbItem);
Vue.component("breadcrumb", Breadcrumb);
Vue.component("data-list", DataList);

//Layout Landing Page
import { ChooseTemplate } from "./components/ChooseTemplate";

Vue.component("choose-template", ChooseTemplate);
