<template>
    <div class="position-fixed w-100 bg-white header-nav">
        <div
            class="d-flex  h-100 justify-space-between w-100"
        >
        <!-- <div> -->
            <VTab @click="Home">Inicio</VTab>

        <!-- </div> -->
        <div  class="d-flex  h-100"> 
            <VTab v-if="!isAutenticated()" @click="Login">Iniciar Sesión</VTab>
            <VTab v-if="!isAutenticated()" @click="Register">Registrarse</VTab>
            <VTab v-if="isAutenticated()" @click="Logout">Salir</VTab>
        </div>
        </div>
    </div>
</template>
<script setup>
import { helperStore, isAutenticated } from './../../helpers/helper'

const helper = helperStore()

const Home = () => window.location.href = '/'
const Login = () => window.location.href = '/auth/login'
const Logout = () => {
    localStorage.removeItem('token')
    window.location.reload()
}
const Register = () => window.location.href = '/auth/register'
</script>
<style>
.header-nav {
    height: 40px;
}
</style>
