import { Breadcrumb, BreadcrumbItem } from "./components/Breadcrumb";
import { DataList } from "./components/DataList";
import { InputFile } from "./components/InputFile";
import { ChooseTemplate } from "./components/ChooseTemplate";
import { Editor, EditorComponent, EditorContent, EditorFooter } from "./components/Editor";

Vue.component("breadcrumb-item", BreadcrumbItem);
Vue.component("breadcrumb", Breadcrumb);
Vue.component("data-list", DataList);
Vue.component('input-file', InputFile);
Vue.component("choose-template", ChooseTemplate);

//Editor
Vue.component("editor", Editor);
Vue.component("editor-component", EditorComponent);
Vue.component("editor-content", EditorContent);
Vue.component("editor-footer", EditorFooter);
