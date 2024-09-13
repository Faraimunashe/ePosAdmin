<template>
      <!-- <NavBar :username="username" /> -->
      <NavBar :username="username" />
        <div class="flex pt-16">
            <div class="flex-1 p-6 bg-gray-100 overflow-y-auto" style="height: calc(100vh - 4rem);">
                <slot />
            </div>
        </div>
      <Footer />
</template>

<script>
import NavBar from './NavBar.vue';
import Footer from './Footer.vue';

export default {
    components: {
        NavBar, Footer
    },
    computed: {
        username() {
            return this.$page.props.auth.user.name
        }
    }
}
</script>
