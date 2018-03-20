<template>
    <div id="header" class="flz-box">
        <div class="flz-box">
            <div class="flz-box">
                <img src="images/logo.png"/>
                <h1>{{ school }}</h1>
                <h2>{{ artOfWork }}</h2>
            </div>
        </div>
    </div>
</template>


<script>
    export default {
        data() {
            return {
                school: 'Htl Donaustadt',
                artOfWork: 'Diplomarbeitsarchiv'
            }
        }
    }
</script>

<style scoped>

</style>