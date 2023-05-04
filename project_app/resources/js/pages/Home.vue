<template>
    <div class="w-6/12 p-10 mx-auto">
        <div class="flex justify-between">
            <h1 class="text-2xl">Profile</h1>
            <span class="capitalize"><a href="/home">{{ user && user.name }}</a>, <button
                class="text-orange-500 underline hover:no-underline rounded-md"
                @click="handleLogout">Logout</button></span>
        </div>
        <Loader v-if="isLoading"/>
        <div v-if="!isLoading" class="border-t mt-3 cursor-pointer tabled">
            <div :class="`py-3 border-b text-gray-600`">
                <span class="field-title">Name</span>
                <span class="field-value">{{ user && user.name }}</span>
            </div>
            <div :class="`py-3 border-b text-gray-600`">
                <span class="field-title">Email</span>
                <span class="field-value">{{ user && user.email }}</span>
            </div>
        </div>
        <br />
        <br />
        <div v-if="!isLoading">
            <a href="/cart">My Cart</a>
        </div>
    </div>
</template>
<script>
import {ref, onMounted} from 'vue'
import {useRouter} from "vue-router";
import {request} from '../helper'
import Loader from '../components/Loader.vue';

export default {
    components: {
        Loader,
    },
    setup() {
        const user = ref()
        const isLoading = ref()

        let router = useRouter();
        onMounted(() => {
            authentication()
        });

        const authentication = async () => {
            isLoading.value = true
            try {
                const req = await request('get', '/api/user')
                user.value = req.data
                isLoading.value = false
            } catch (e) {
                await router.push('/')
            }
        }

        const handleLogout = () => {
            localStorage.removeItem('APP_DEMO_USER_TOKEN')
            router.push('/')
        }

        return {
            user,
            isLoading,
            handleLogout,
        }
    },
}
</script>
