<template>
    <div class="flz-box flz-25 flz-nospacer">
        <login></login>
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
        data() {
            return {
                title: 'Njnja App'
            }
        }
    }
</script>
<style scoped>

</style>