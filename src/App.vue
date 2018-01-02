<template>
    <div>
        <app-header></app-header>
        <a href="http://localhost:63342/vuecli-n1/index.php?_ijt=2hq088vpip0brq2sid6b5t0aph">click</a>
    </div>
</template>

<script>
    import Header from './Header.vue'
    import Body from './Body.vue'
    import Footer from './Footer.vue'

    export default {
        components: {
            'app-header': Header,
            'app-body': Body,
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
