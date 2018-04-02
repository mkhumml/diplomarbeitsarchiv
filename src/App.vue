<template>
    <div class="flz-box flz-nospacer">
        <!--
        Header of the application
        -->
        <app-header class="flz-box flz-nospacer">
        </app-header>
        <div class="flz-box">
            <!--
            Sidenavigation (Login, Activitylog)
            loggedIn is the true/false property used for authentication and authorisation
            -->
            <app-sideNav :loggedIn="loggedIn" @onSuccessLogin="onSuccessLogin($event)"
                         class="flz-box flz-25-gte-l flz-100-lte-m">
            </app-sideNav>
            <!--
            Content of the app (List of diploma, diploma formular
            -->
            <div class="flz-box flz-75-gte-l flz-100-lte-m">
                <app-main :loggedIn="loggedIn" class="flz-box">
                </app-main>
            </div>
        </div>
    </div>
</template>

<script>
    // importing components
    import Header from './Header.vue'
    import Main from './Main.vue'
    import Footer from './Footer.vue'
    import SideNav from './Sidenav.vue'

    export default {
        //declare components
        components: {
            'app-header': Header,
            'app-sideNav': SideNav,
            'app-main': Main,
            'app-footer': Footer
        },
        //declare loggedIn for authorisation/authentication
        data() {
            return {
                loggedIn: false
            }
        },
        methods: {
            //method which gets implemented when the event "onSuccessLogin" gets fired
            onSuccessLogin($event) {
                this.loggedIn = $event;
            }
        }
    }
</script>

<style lang="scss">

</style>
