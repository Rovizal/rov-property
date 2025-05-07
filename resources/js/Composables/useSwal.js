// useSwal.js
import { getCurrentInstance } from "vue";

export default function useSwal() {
    const { proxy } = getCurrentInstance();

    if (!proxy?.$swal) {
        throw new Error(
            "SweetAlert2 is not available. Did you forget to install and register vue-sweetalert2?"
        );
    }

    return proxy.$swal;
}
