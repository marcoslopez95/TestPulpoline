export const required = (value) => (value ? true : 'Requerido')

export const password = (pass) => {
    const validate = /^(?=.*[a-záéíóúüñ])(?=.*[0-9])(?=.*[A-ZÁÉÍÓÚÜÑ])(?=.*\d)(?=.*[-_@$!%*?&€£.,¡¿])[A-Za-záéíóúüñÁÉÍÓÚÜÑ\d\-_@$!%*?&#€£.,¡¿]{8,}$/;
    if (validate.test(pass)) {
        return true;
    }
    return 'No cumple con lo establecido';
};

export const confirmPassword = (value, confirm) => value === confirm || 'Las contraseñas no coinciden'

export const email = (email) => {
    const validate = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (validate.test(email)) { return true; } return 'Debe ser un correo válido';
};

export const onlyLetters = (email) => {
    const validate = /^[A-ZÁÉÍÓÚÑ ]+$/i;
    if (validate.test(email)) { return true; } return 'Solo letras';
};

export const onlyNumbers = (number) => {
    const validate = /^[0-9 ]+$/i; if (validate.test(number)) { return true; } return 'Solo números';
};

export const min = (value,min) => {
    if(value.length >= min) return true
    return `Debe ser mínimo ${min} caracteres`
};