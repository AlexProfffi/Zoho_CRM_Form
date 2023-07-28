<template>
    <div>
        <Head>
            <title>Welcome</title>
        </Head>

        <img :src="getImageUrl(imagePath)" alt="">

        <Link :href="route('categories')">categories</Link>

        <form @submit.prevent="submitToken">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" v-model="tokenForm.email" class="form-control" id="email">
                <div class="errors" v-if="tokenForm.errors.email">{{ tokenForm.errors.email }}</div>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="text" v-model="tokenForm.password" class="form-control" id="password">
                <div class="errors" v-if="tokenForm.errors.password">{{ tokenForm.errors.password }}</div>
            </div>
            <div class="form-group">
                <label for="device_name">Device_name</label>
                <input type="text" v-model="tokenForm.device_name" class="form-control" id="device_name">
                <div class="errors" v-if="tokenForm.errors.device_name">{{ tokenForm.errors.device_name }}</div>
            </div>
            <button type="submit" class="btn btn-primary button-ok">Submit</button>
        </form>
    </div>
</template>


<script setup>

// ======== Import ========

import MainLayout from "@/Layouts/MainLayout.vue";
import { Head, Link } from '@inertiajs/vue3'
import { getImageUrl } from "@/helpers";
import { useForm } from '@inertiajs/vue3';


// ======== Options ========

defineOptions({ layout: MainLayout })


// ======== Props ========

const props = defineProps({
    imagePath: String
})


// ------ Data -------

const tokenForm = useForm({
    email: undefined,
    password: undefined,
    device_name: undefined
})


// ------- Methods --------

const submitToken = () => {

    tokenForm.post(route('sanctum.token'), { // example submit form(маршрут надо указать свой)

        onFinish: () => tokenForm.reset('password'),
    });
}

</script>


<style scoped>

</style>
