<template>
    <div class="page ">
        <VCard class="" width="500" rounded="xl" elevation="10">
            <VCardTitle class="py-4 text-center font-weight-bold"> Iniciar Sesión </VCardTitle>
            <!-- <hr class="border border-light"> -->
            <VCardText class="px-10">
                <VForm ref="formRef" validate-on="input">

                    <VTextField 
                    class="my-2"
                    v-model="form.email" label="Correo Electrónico" 
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
                        @click:append-inner="showPassword = !showPassword"
                        :rules="[
                            validator.required,
                            validator.min(form.password,6),
                        ]"  
                    />
                </VForm>
            </VCardText>
            
            <VCardActions class="border-t py-5 px-4">
                <div class="d-flex w-100 justify-space-between">
                    <VBtn @click="goHome" class="font-weight-bold">Atrás</VBtn>
                    <VBtn 
                        type="button" 
                        @click="login" variant="tonal" color="info" class="font-weight-bold"
                        :disabled="loading"

                        >
                        {{ loading ? 'Enviando' : 'Enviar' }}
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
import { helperStore } from './../../helpers/helper'
import * as validator from "@init/validator";
const helper = helperStore()
const loading = ref(false)
const formRef = ref()
const form = reactive({
    email: "",
    password: "",
});
const showPassword = ref(false);

const login = async() => {
    const { valid } = await formRef.value.validate();

    if (!valid) return;
    loading.value = true
    const url = '/auth/login'
    const data = form
    helper
        .http(url,'post', { data },'Registro Exitoso')
        .then((data)=> {
            const token = data.data.data
            localStorage.setItem('token',token)
            form.email = ""
            form.password = ""
            formRef.value.resetValidation();
            window.location.href = '/'
        }).finally(()=>loading.value = false);

}

const goHome = () => window.location.href = '/'
</script>
<style>

</style>
