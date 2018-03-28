<template>
    <div>
        <login :loggedIn="loggedIn" @onSuccessLogin="onSuccessLogin($event)"></login>
        <activitylog></activitylog>
    </div>
</template>

<script>
    import Login from './Login.vue'
    import Activitylog from './Activitylog.vue'

    export default {
        components: {
            'login': Login,
            'activitylog': Activitylog
        },
        props: {
          loggedIn: {
              type: Boolean,
              required: true
          }
        },
        data() {
            return {
                title: 'Njnja App'
            }
        },
        methods: {
            onSuccessLogin($event) {
                this.$emit("onSuccessLogin",$event)
            }
        }
    }
</script>
<style scoped>

</style>