<template>
    <div class="page ">
        <VCard class="" width="500" rounded="xl" elevation="10">
            <VCardTitle class="py-4 text-center font-weight-bold"> Registro </VCardTitle>
            <!-- <hr class="border border-light"> -->
            <VCardText class="px-10">
                <VForm>
                    <VTextField v-model="form.email" label="Correo Electrónico" />
                    <VTextField
                        v-model="form.password"
                        label="Contraseña"
                        :append-inner-icon="
                            showPassword ? 'mdi-eye' : 'mdi-eye-closed'
                        "
                        :type="showPassword ? 'text' : 'password'"
                        @click:append-inner="showPassword = !showPassword"
                    />
                    <VTextField
                        v-model="form.password_confirmation"
                        label="Confirmar Contraseña"
                        :append-inner-icon="
                            showPasswordConfirmation ? 'mdi-eye' : 'mdi-eye-closed'
                        "
                        :type="showPasswordConfirmation ? 'text' : 'password'"
                        @click:append-inner="showPasswordConfirmation = !showPasswordConfirmation"
                    />
                </VForm>
            </VCardText>
            
            <VCardActions class="border-t py-5 px-4">
                <div class="d-flex w-100 justify-space-between">
                    <VBtn @click="goHome" class="font-weight-bold">Atrás</VBtn>
                    <VBtn type="button" @click="registerF" variant="tonal" color="info" class="font-weight-bold"
                        >Guardar</VBtn
                    >
                </div>
            </VCardActions>
        </VCard>
    </div>
</template>

<script setup>
import { reactive } from "vue";
import { ref } from "vue";
import { helperStore } from './../../helpers/helper'
const helper = helperStore()
const form = reactive({
    email: "",
    first_name: "",
    last_name: "",
    password: "",
    password_confirmation: "",
});
const showPassword = ref(false);
const showPasswordConfirmation = ref(false);

const registerF = () => {
    const url = '/auth/register'
    const data = form
    helper
        .http(url,'post', { data },'Registro Exitoso')
        .then(()=> {
            form.email = ""
            form.first_name = ""
            form.last_name = ""
            form.password = ""
            form.password_confirmation = ""
        })
}

const goHome = () => window.location.href = '/'
</script>
<style>

</style>
