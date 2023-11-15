import { useToast } from "vue-toastification";
import axios from 'axios'

export const isAutenticated = () => {
    return localStorage.getItem("token") || false;
};

export const helperStore = () => {
    const toast = useToast();
    const http = (url, method = "get", options = {}, notification = "") => {
        return new Promise(async (resolve, reject) => {
            try {
                let config = {
                    url,
                    method,
                    ...options,
                };
                if (isAutenticated()) {
                    config.headers = {
                        Authorization: `Bearer ${localStorage.getItem(
                            "token"
                        )}`,
                    };
                }
                let response = await axios(config);
                if (notification) {
                    showNotify(notification);
                }
                resolve(response);
            } catch (error) {
                let messages;
                if (error.response && error.response.status >= 500) {
                    messages = t("commons.system-error");
                }
                {
                    const data = error.response.data;
                    messages =
                        data.message ??
                        data.data?.errors ??
                        data.errors.message;
                }

                if (typeof messages === "string") {
                    showNotify(messages, { type: "error" });
                } else {
                    getErrors(error.response.data.data.errors);
                }
                if (error.response && error.response.status === 401) {
                    localStorage.removeItem("token");
                    localStorage.removeItem("user");
                    router.push("/login");
                }
                reject(error);
            }
        });
    };

    const getErrors = (errors) => {
        let error = [];
        let op = {
            type: "error",
        };
        if (errors) {
            for (let err in errors) {
                error.push(errors[err]);
            }
        }
        console.log(error);
        error.forEach((er) => showNotify(er, op));
    };

    const showNotify = (msg, options = { type: "success" }) => {
        toast(msg, {
            theme: "colored",
            ...options,
        }); // ToastOptions
    };

    return {
        showNotify,
        getErrors,
        http
    };
};

export const amountFormat = (event, length = 2) => {
    const text = event.target.value;
    let reem = text
        .toString()
        .toString()
        .replace(/[^0-9]/g, ""); // quitando todo lo que no sea números
    if (reem.length < length && event.key == "Backspace") {
        // Si la cantidad restante de dígitos es menor a el valor y además se está borrando
        // if (reem.length == length-1) {
        // Si la cantidad de dígitos es igual a un numero inferior que el total de digitos
        reem = "0" + reem; // agrego un cero al principio
        // }
    } else {
        if (reem.substring(0, 1) == "0") {
            // Si el primero número es un cero
            let subNum = reem.substring(1, reem.length); // obtengo el resto de números
            reem = subNum; // es decir, los "decimales"

            if (subNum.length > length + 1 && subNum.substring(0, 2) == "00") {
                // Si los recimales es mayor que mi número total  y los dos primeros son ceros
                let subNumber = subNum.substring(2, subNum.length); // quito los dos primeros ceros
                reem = subNumber; // igualo
            }
        }
    }
    console.log("numero", reem);
    // 9        - (8 -1)
    let partInteger = reem.substring(0, reem.length - (length - 1)); // parte entera
    if (partInteger.length == 2 && partInteger == "00") {
        partInteger = "0";
    }
    const partDecimal = reem.substring(reem.length - (length - 1), reem.length); // parte decimal
    var coma = partInteger + "," + partDecimal;

    // agrupar de a grupos de a 3 antes de la coma y añadie un .
    event.target.value = coma.toString().replace(/\d(?=(\d{3})+\,)/g, "$&.");
    console.log("numero2", event.target.value);
    if (event.target.value != null) {
        for (let i = 0; i < event.target.value.length; i++) {
            if (event.target.value.indexOf(",,") != -1) {
                event.target.value = event.target.value.split(",,").join(",");
            }
        }
    }
    console.log("ifpenu", event.target.value);
    if (event.target.value.length < length + 1) {
        const lengthCurrent = event.target.value.length;
        const lengthTotal = length + 1;
        event.target.value =
            "0," +
            "0".repeat(lengthTotal - lengthCurrent) +
            event.target.value.replace(",", "");
    }
    console.log("return", event.target.value);
    return event.target.value;
};

export const transformAmount = (amount) => {
    let newstring = amount.split(".").join("");
    console.log("este es el monto " + newstring);
    newstring = newstring.replace(",", ".");
    console.log("este es el monto " + newstring);
    return parseFloat(newstring);
};

export const formatNumber = (
    number,
    decimalSeparator = ",",
    thousandSeparator = ".",
    decimals = 3
) => {
    const partInt = Math.trunc(number);
    let roundedNumber;

    if (number - partInt > 0) {
        roundedNumber = parseFloat(number.toFixed(decimals));
    } else {
        roundedNumber = partInt;
        decimals = 0;
    }

    const [integerPart, decimalPart] = roundedNumber
        .toFixed(decimals)
        .split(".");
    const formattedIntegerPart = integerPart.replace(
        /\B(?=(\d{3})+(?!\d))/g,
        thousandSeparator
    );

    const formattedDecimalPart = decimalPart
        ? `${decimalSeparator}${decimalPart}`
        : `${decimalSeparator}00`;
    // console.log('number,integerPart, decimalPart',number,formattedIntegerPart, formattedDecimalPart)

    if (decimals === 0) {
        return `${formattedIntegerPart}`;
    }
    return `${formattedIntegerPart}${formattedDecimalPart}`;
};
