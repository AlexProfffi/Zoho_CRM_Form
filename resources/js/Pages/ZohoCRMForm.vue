<template>
    <div>
        <Head>
            <title>Zoho CRM Form</title>
        </Head>

        <form class="zoho-crm-form" @submit.prevent="submitZohoCRMForm">
            <Toast position="top-center" />
            <h1 class="header">Zoho CRM Form</h1>
            <div class="group">
                <label class="label" for="Account_name">Account name</label>
                <div>
                    <InputText v-bind="Account_name" class="input-text" id="Account_name"
                               v-model="zohoCRMForm.Account_name" />
                    <div class="p-error">{{ errors.Account_name }}</div>
                </div>
            </div>
            <div class="group">
                <label class="label" for="Account_website">Account website</label>
                <div>
                    <InputText v-bind="Account_website" class="input-text" id="Account_website"
                               v-model="zohoCRMForm.Account_website" />
                    <div class="p-error">{{ errors.Account_website }}</div>
                </div>
            </div>
            <div class="group">
                <label class="label" for="Account_phone">Account phone</label>
                <div>
                    <InputText v-bind="Account_phone" class="input-text" id="Account_phone"
                               v-model="zohoCRMForm.Account_phone" />
                    <div class="p-error">{{ errors.Account_phone }}</div>
                </div>
            </div>
            <div class="group">
                <label class="label" for="Deal_name">Deal name</label>
                <div>
                    <InputText v-bind="Deal_name" class="input-text" id="Deal_name"
                               v-model="zohoCRMForm.Deal_name" />
                    <div class="p-error">{{ errors.Deal_name }}</div>
                </div>
            </div>
            <div class="group">
                <label class="label">Deal stage</label>
                <div>
                    <Dropdown v-bind="Deal_stage" class="dropdown"
                              v-model="zohoCRMForm.Deal_stage" :options="dealStages" placeholder="Select deal stage" />
                    <div class="p-error">{{ errors.Deal_stage }}</div>
                </div>
            </div>
            <div class="group">
                <label class="label">Deal closing date</label>
                <div>
                    <Calendar v-bind="Deal_closing_date" :modelValue="zohoCRMForm.Deal_closing_date"
                              @update:modelValue="zohoCRMForm.Deal_closing_date = updateDeal_closing_dateValue($event)"
                              class="calendar"
                              dateFormat="dd.mm.yy" placeholder="DD.MM.YYYY" />
                    <div class="p-error">{{ errors.Deal_closing_date }}</div>
                </div>
            </div>
            <div class="group">
                <Button class="submit" type="submit" label="Submit" />
            </div>
        </form>
    </div>
</template>


<script setup>

// ======== Import ========

import MainLayout from "@/Layouts/MainLayout.vue"

import {ref, toRefs} from "vue";

import { Head } from '@inertiajs/vue3'
import { useForm } from '@inertiajs/vue3'

import InputText from 'primevue/inputtext';
import Dropdown from 'primevue/dropdown';
import Calendar from 'primevue/calendar';
import Button from 'primevue/button';

import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';
const toast = useToast();

import { useForm as useVeeValidate } from 'vee-validate';
import { toTypedSchema } from '@vee-validate/zod';
import {z} from 'zod';


// ======== Options ========

defineOptions({ layout: MainLayout })


// ======== Props ========

const props = defineProps({
    message: Object
})

const { message } = toRefs(props)


// ======== Use VeeValidate ========

const { errors, defineInputBinds, handleSubmit, setFieldValue } = useVeeValidate({
    validationSchema: toTypedSchema(
        z.object({
            Account_name: z.string({required_error: 'Account name is required'}).min(3),

            Account_website: z.string().refine((value) =>
                    /https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)/.test(value),
                'Invalid website. Example: "https://www.zylker.com"').optional().or(z.literal('')),

            Account_phone: z.string().refine((value) =>
                    /(?:([+]\d{1,4})[-.\s]?)?(?:[(](\d{1,3})[)][-.\s]?)?(\d{1,4})[-.\s]?(\d{1,4})[-.\s]?(\d{1,9})/.test(value),
                'Invalid phone. Example: "555-555-555"').optional().or(z.literal('')),

            Deal_name: z.string({required_error: 'Deal name is required'}).min(2),

            Deal_stage: z.object({value: z.string({required_error: 'Deal stage is required'})}),

            Deal_closing_date: z.string({required_error: 'Deal closing date is required'})
        }),
    ),
})


// ------ Data -------

const Account_name = defineInputBinds('Account_name', {validateOnInput: true});
const Account_website = defineInputBinds('Account_website', {validateOnInput: true});
const Account_phone = defineInputBinds('Account_phone', {validateOnInput: true});
const Deal_name = defineInputBinds('Deal_name', {validateOnInput: true});
const Deal_stage = defineInputBinds('Deal_stage', {validateOnInput: true});
const Deal_closing_date = defineInputBinds('Deal_closing_date', {validateOnInput: true});


// ------- Methods --------

const updateDeal_closing_dateValue = (event) => {

    setFieldValue('Deal_closing_date', zohoCRMForm.Deal_closing_date);

    return event;
}


// ======== Zoho CRM Form ========

// ------ Data -------

const zohoCRMForm = useForm({
    Account_name: '',
    Account_website: '',
    Account_phone: '',
    Deal_name: '',
    Deal_stage: '',
    Deal_closing_date: '',
})

const dealStages = ref([
    'Qualification',
    'Needs Analysis',
    'Value Proposition',
    'Identify Decision Makers',
    'Proposal/Price Quote',
    'Negotiation/Review',
    'Closed Won',
    'Closed Lost',
    'Closed Lost to Competition'
]);


// ------- Methods --------

const submitZohoCRMForm = handleSubmit(() => {

    zohoCRMForm.post(route('zoho_crm_form.store'), {

        onFinish: () => {

            if(message.value.success) {
                toast.add({ severity: 'success', summary: 'Success', detail: message.value.success, life: 6000 });
            }

            if(message.value.account_error) {
                toast.add({ severity: 'error', summary: 'Error', detail: message.value.account_error, life: 6000 });
            }

            if(message.value.deal_error) {
                toast.add({ severity: 'error', summary: 'Error', detail: message.value.deal_error, life: 6000 });
            }
        },
    })
})

</script>


<style scoped>

    .zoho-crm-form {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .header {
        text-align: center;
    }

    .group {
        display: flex;
        align-items: center;
        margin-bottom: 1.6rem;
    }

    .label {
        text-align: right;
        width: 10rem;
        margin-right: 1rem
    }

    .p-error {
        position: absolute;
        font-size: 0.9rem;
        margin-top: 1px;
        white-space: pre;
    }

    .input-text {
        padding: 0.3rem 0.3rem;
    }

    .input-text, .dropdown, .calendar {
        width: 16rem;
    }

    .submit {
        margin-left: auto;
    }

</style>
