import "../css/app.css";
import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import { ZiggyVue } from "ziggy";
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";

const options = {
    // Posisi munculnya toast
    position: "top-right", // bisa juga "top-center", "bottom-left", dll.

    // Lama tampil (ms)
    timeout: 3000,

    // Bisa di-dismiss manual
    closeOnClick: true,

    // Pause saat hover (biar user bisa baca dulu)
    pauseOnHover: true,

    // Show progress bar
    showCloseButtonOnHover: false,
    hideProgressBar: false,
    closeButton: "button",

    // Animasi
    transition: "Vue-Toastification__fade",

    // Max jumlah toast aktif (bisa disesuaikan biar gak spam)
    maxToasts: 5,

    // Text direction
    rtl: false,
};

createInertiaApp({
    resolve: async (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        // return pages[`./Pages/${name}.vue`];

        const page = await pages[`./Pages/${name}.vue`];
        page.default.layout = page.default.layout || MainLayout;
        return page;
    },
    // function (){}
    // arrow function ()=>
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(Toast, options)
            .use(VueSweetalert2)
            .use(ZiggyVue)
            .mount(el);
    },
});
