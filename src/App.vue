<template>
    <div class="flz-nospacer">
        <app-header class="flz-box flz-nospacer">
        </app-header>
        <div class="flz-box flz-nospacer">
            <p class="flz-nospacer">Startseite</p>
            <app-sideNav class="flz-box flz-25-gte-l flz-100-lte-m flz-nospacer">
            </app-sideNav>
            <div class="flz-box flz-75-gte-l flz-100-lte-m flz-nospacer">
                <app-main class="flz-box">
                </app-main>
            </div>
        </div>
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
        },
        methods: {}
    }
</script>

<style lang="scss">

</style>
