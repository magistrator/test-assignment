<template>
    <div class="w-6/12 p-10 mx-auto">
        <div class="flex justify-between">
            <h1 class="text-2xl">Cart</h1>
            <span class="capitalize"><a href="/home">{{ user && user.name }}</a>, <button
                class="text-orange-500 underline hover:no-underline rounded-md"
                @click="handleLogout">Logout</button></span>
        </div>
        <Loader v-if="isLoading"/>
        <div v-if="!isLoading" class="border-t mt-3 cursor-pointer tabled">
            <div :class="`py-3 border-b text-gray-600`">
                <span class="field-id">ID</span>
                <span class="field-name">NAME</span>
                <span class="field-sku">SKU</span>
                <span class="field-price">PRICE</span>
                <span class="button"></span>
            </div>

            <div :class="`py-3 border-b text-gray-600`"
                v-for="(val, idx) in products" :key="idx">
                <span class="field-id">{{ val.id }}</span>
                <span class="field-name">{{ val.name }}</span>
                <span class="field-sku">{{ val.sku }}</span>
                <span class="field-price">$ {{ val.price }}</span>
                <span class="button">
                    <button class="bg-red-400 px-2 text-white font-bold rounded-md hover:bg-red-600"
                        @click="deleteProduct(val, idx)">&times;
                    </button>
                </span>
            </div>
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
        const products = ref([])
        const user = ref()
        const isLoading = ref()

        let router = useRouter();
        onMounted(() => {
            authentication()
            handleProducts()
        });

        const authentication = async () => {
            isLoading.value = true
            try {
                const req = await request('get', '/api/user')
                user.value = req.data
            } catch (e) {
                await router.push('/')
            }
        }

        const handleProducts = async () => {
            try {
                const req = await request('get', '/api/products')
                products.value = req.data.data
            } catch (e) {
                await router.push('/')
            }
            isLoading.value = false
        }

        const handleLogout = () => {
            localStorage.removeItem('APP_DEMO_USER_TOKEN')
            router.push('/')
        }

        const deleteProduct = async (val, index) => {
            if (window.confirm("Are you sure")) {
                try {
                    isLoading.value = false
                    products.value.splice(index, 1)
                } catch (e) {
                    await router.push('/')
                }
                isLoading.value = false
            }
        }

        return {
            products,
            user,
            isLoading,
            deleteProduct,
            handleLogout,
        }
    },
}
</script>
