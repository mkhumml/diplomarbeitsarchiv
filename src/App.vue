<template>
    <div>
        <app-header></app-header>
        <div class="flz-box">
            <a href="#">Startseite</a>
        </div>
        <app-sideNav></app-sideNav>
        <app-main></app-main>
    </div>
</template>

<script>
    import Header from './Header.vue'
    import Main from './Main.vue'
    import Footer from './Footer.vue'
    import SideNav from './Sidenav.vue'

    export default {
        components: {
            'app-header': Header,
            'app-sideNav': SideNav,
            'app-main': Main,
            'app-footer': Footer
        },
        data() {
            return {
                title: 'Njnja App'
            }
        }
    }
</script>

<style lang="scss">

</style>
