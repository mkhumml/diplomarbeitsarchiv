<template>
    <div id="main" class="flz-box flz-75">
        <div class="flz-box">
            <button v-on:click="hide = !hide" v-on:click="giveData">asdf</button>
            <div v-if="hide" class="flz-box flz-nospacer">
                <div class="searching flz-nospacer">
                    <div class="flz-box flz-20 flz-nospacer">
                        <h1>Diplomarbeiten</h1>
                    </div>
                    <div class="flz-box flz-60 flz-nospacer">
                        <input type="text" name="search" placeholder="search..">
                    </div>
                    <div class="flz-box flz-20 flz-nospacer">
                        <a href="#">Erweiterte Suche</a>
                    </div>
                </div>
                <div v-for="item in diplomaList" :key="item.id">
                    <app-content :test1="item.Title" :diploma="item"></app-content>
                </div>

            </div>
            <div v-else-if="hide === false" class="flz-box flz-nospacer">
                <app-details></app-details>
            </div>
        </div>
    </div>
</template>
<script>
    import Content from './Content.vue'
    import Details from './Details.vue'

    export default {
        components: {
            'app-content': Content,
            'app-details': Details
        },
        data() {
            return {
                diplomaList : [{"id":28,"Title":"Sweden"}, {"id":56,"Title":"USA"}, {"id":89,"Title":"England"}],
                hide: true
            }
        }
    }
</script>

<style scoped>

</style>