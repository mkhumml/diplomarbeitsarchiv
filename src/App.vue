<template>
    <div class="flz-box flz-nospacer">
        <app-header class="flz-box flz-nospacer">
        </app-header>
        <div class="flz-box">
            <app-sideNav :loggedIn="loggedIn" @onSuccessLogin="onSuccessLogin($event)"
                         class="flz-box flz-25-gte-l flz-100-lte-m">
            </app-sideNav>
            <div class="flz-box flz-75-gte-l flz-100-lte-m">
                <app-main :loggedIn="loggedIn" class="flz-box">
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
                loggedIn: false
            }
        },
        methods: {
            onSuccessLogin($event) {
                this.loggedIn = $event;
            }
        }
    }
</script>

<style lang="scss">

</style>
