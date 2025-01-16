import {toast} from 'react-toastify';

const TOAST_TYPES = {
    SUCCESS: 'success',
    ERROR: 'error',
    INFO: 'info',
};

const Toast = (message, type = TOAST_TYPES.INFO, options = {}) => {
    const defaultOptions = {
        toastId: Math.random().toString(36).substring(7), // Unique ID for the toast
        position: 'top-right',
        autoClose: 2000,
        hideProgressBar: true,
        closeOnClick: true,
        pauseOnHover: true,
        ...options, // Allows for overriding or adding additional options
    };

    switch (type) {
        case TOAST_TYPES.SUCCESS:
            toast.success(message, defaultOptions);
            break;
        case TOAST_TYPES.ERROR:
            toast.error(message, defaultOptions);
            break;
        default:
            toast.info(message, defaultOptions);
    }
};

export default Toast;
export {TOAST_TYPES};
