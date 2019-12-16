import { Breadcrumb, BreadcrumbItem } from "./components/Breadcrumb";
import { DataList } from "./components/DataList";
import { InputFile } from "./components/InputFile";
import { CalendarComponent } from "./components/Calendar";
import {Calendar} from 'vue-bootstrap4-calendar';

Vue.component("my-calendar", CalendarComponent);
Vue.component("calendar", Calendar);
Vue.component("breadcrumb-item", BreadcrumbItem);
Vue.component("breadcrumb", Breadcrumb);
Vue.component("data-list", DataList);
Vue.component('input-file', InputFile);