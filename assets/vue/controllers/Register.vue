<template>
    <div class="page">
        <VCard class="" width="500" rounded="xl" elevation="10">
            <VCardTitle class="py-4 text-center font-weight-bold">
                Registro
            </VCardTitle>
            <!-- <hr class="border border-light"> -->
            <VCardText class="px-10">
                <VForm ref="formRef" validate-on="input">
                    <VTextField
                        class="my-2"
                        v-model="form.email"
                        label="Correo Electrónico"
                        :rules="[validator.required, validator.email]"
                    />
                    <VTextField
                        class="my-2"
                        v-model="form.password"
                        label="Contraseña"
                        :append-inner-icon="
                            showPassword ? 'mdi-eye' : 'mdi-eye-closed'
                        "
                        :type="showPassword ? 'text' : 'password'"
                        :rules="[
                            validator.required,
                            validator.min(form.password,6),
                        ]"  
                        @click:append-inner="showPassword = !showPassword"
                    />
                    <VTextField
                        class="my-2"
                        v-model="form.password_confirmation"
                        label="Confirmar Contraseña"
                        :rules="[
                            validator.required,
                            validator.confirmPassword(form.password_confirmation,form.password)
                        ]"
                        :append-inner-icon="
                            showPasswordConfirmation
                                ? 'mdi-eye'
                                : 'mdi-eye-closed'
                        "
                        :type="showPasswordConfirmation ? 'text' : 'password'"
                        @click:append-inner="
                            showPasswordConfirmation = !showPasswordConfirmation
                        "
                    />
                </VForm>
            </VCardText>

            <VCardActions class="border-t py-5 px-4">
                <div class="d-flex w-100 justify-space-between">
                    <VBtn @click="goHome" class="font-weight-bold">Atrás</VBtn>
                    <VBtn
                        type="button"
                        @click="registerF"
                        variant="tonal"
                        color="info"
                        class="font-weight-bold"
                        :disabled="loading"
                        >
                        {{ loading ? 'Guardando' : 'Guardar' }}
                    </VBtn
                    >
                </div>
            </VCardActions>
        </VCard>
    </div>
</template>

<script setup>
import { reactive } from "vue";
import { ref } from "vue";
import { helperStore } from "./../../helpers/helper";
import * as validator from "@init/validator";

const helper = helperStore();
const formRef = ref()
const loading = ref(false)
const form = reactive({
    email: "",
    password: "",
    password_confirmation: "",
});
const showPassword = ref(false);
const showPasswordConfirmation = ref(false);

const registerF = async () => {
    const { valid } = await formRef.value.validate();

    if (!valid) return;
    loading.value = true
    const url = "/auth/register";
    const data = form;
    helper.http(url, "post", { data }, "Registro Exitoso").then(() => {
        form.email = "";
        form.password = "";
        formRef.value.resetValidation();
    }).finally(()=>loading.value = false);
};

const goHome = () => (window.location.href = "/");
</script>
<style></style>
