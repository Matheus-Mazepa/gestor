import { Breadcrumb, BreadcrumbItem } from "./components/Breadcrumb";
import { DataList } from "./components/DataList";
import { InputFile } from "./components/InputFile";
import { CalendarComponent } from "./components/Calendar";
import {Calendar} from 'vue-bootstrap4-calendar';
import {CreateOrder} from './components/Orders';
import {ClientForm} from './components/ClientForm';
import {RegisterAddressComponent} from './components/RegisterAddress';
import { CustomSelect } from "./components/Select";
import { BundleProduct } from './components/Products'
import vSelect from 'vue-select'

Vue.component('bundle-product', BundleProduct);
Vue.component('create-order', CreateOrder);
Vue.component('v-select', vSelect);
Vue.component("custom-select", CustomSelect);
Vue.component("my-calendar", CalendarComponent);
Vue.component("calendar", Calendar);
Vue.component("breadcrumb-item", BreadcrumbItem);
Vue.component("breadcrumb", Breadcrumb);
Vue.component("data-list", DataList);
Vue.component('input-file', InputFile);
Vue.component('client-form', ClientForm);
Vue.component('register-address-component', RegisterAddressComponent);
