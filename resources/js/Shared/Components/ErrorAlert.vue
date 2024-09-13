<template>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mb-2 rounded relative" role="alert">
        <strong class="font-bold mr-2">Success!</strong>
        <span class="block sm:inline">{{ message }}</span>
    </div>
</template>

<script>
    export default {
        props: {
            message: String
        }
    }
</script>
