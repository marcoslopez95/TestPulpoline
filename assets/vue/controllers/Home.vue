<template>
    <div class="page ">
        <VCard class="" :width="$vuetify.display.smAndDown? '340px' : '900px'" rounded="xl" elevation="16">
            <VCardTitle class="py-4 text-center font-weight-bold">
                Conversor
            </VCardTitle>
            <!-- <hr class="border border-light"> -->
            <VCardText class="px-10">
                <VRow>
                    <VCol cols="12" md="3">
                        <VTextField
                            v-model="form.amount"
                            label="Monto"
                            @keyup='eventKeypress'
                        >
                            <template #append-inner>
                                {{ symbolAmount }}
                            </template>
                        </VTextField>
                    </VCol>
                    <VCol cols="12" md="4">
                        <VSelect
                            v-model="form.from"
                            :items="currencies"
                            item-value="iso3"
                            item-title="nombre"
                            label="De:"
                        />
                    </VCol>
                    <VCol cols="12" md="1">
                        <VBtn @click="changeCurrencies" icon="mdi-account" />
                    </VCol>
                    <VCol cols="12" md="4">
                        <VSelect
                            v-model="form.to"
                            :items="currencies"
                            item-value="iso3"
                            item-title="nombre"
                            label="A:"
                        />
                    </VCol>
                </VRow>
                <VRow v-show="showExchange">
                    <VCol>
                        <div>
                            <small>1 {{ symbolAmount }} = {{ formatNumber(exchange) }} {{ symbolDestiny }} </small>
                            <div class="font-weight-bold text-h3">
                                {{ formatNumber(amountEnd) }} {{ symbolDestiny }} 
                            </div>
                        </div>
                    </VCol>
                </VRow>
            </VCardText>

            <VCardActions class="border-t py-5 px-4">
                <div class="d-flex w-100 justify-end">
                    <!-- <VBtn class="font-weight-bold">Atrás</VBtn> -->
                    <VBtn @click="getExchange" variant="tonal" color="info" class="font-weight-bold"
                        >Convertir</VBtn
                    >
                </div>
            </VCardActions>
        </VCard>
    </div>
</template>

<script setup>
import currencies from './../../helpers/currencies.json'
import { formatNumber,amountFormat } from './../../helpers/helper'
import { reactive } from "vue";
import { ref,watch, computed } from "vue";

const form = reactive({
    amount: "",
    from: '',
    to: '',
});

const symbolAmount  = computed(()=>currencies.find( c => c.iso3 === form.from)?.simbolo ?? '')
const symbolDestiny = computed(()=>currencies.find( c => c.iso3 === form.to)?.simbolo ?? '')
const exchange = ref(0)
const amountEnd = ref(123123)
const showExchange = ref(false)

const eventKeypress = (event) => form.amount = amountFormat(event)
form.from = currencies[0].iso3
form.to = currencies[1].iso3

const changeCurrencies = () => {
    const from = form.from
    const to = form.to
    form.from = to
    form.to = from
}

const getExchange = async () => {

    showExchange.value = false
    setTimeout(()=>{
        showExchange.value = true
    },5000)
}

</script>
<style>

</style>
