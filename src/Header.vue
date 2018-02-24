<template>
    <div id="header" class="flz-box">
        <div class="article">
            <div class="flz-box flz-10">
               <img src="images/Download.jpeg"/>
            </div>
            <div class="flz-box flz-90">
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