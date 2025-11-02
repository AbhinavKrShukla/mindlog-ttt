<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div
        class="flex min-h-screen flex-col items-center bg-gray-100 pt-6 sm:justify-center sm:pt-0"  style="background-image: url('/images/image.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;"
    >
        <div>
            <Link href="/">
                <img src="/images/logoD.png" alt="Diary Background" class="w-full h-auto" />
            </Link>
        </div>

        <div
            class="mt-6 align-items-center items-center w-[90%] overflow-hidden bg-white px-6 py-4 shadow-md border rounded sm:max-w-md sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
