<template>
    <div class="flz-box content">
        <div class="flz-box flz-nospacer">
            <div class="flz-box flz-nospacer">
                <div class="flz-box flz-5 flz-nospacer">
                    <img class="icon" src="Images/Download.jpeg"/>
                </div>
                <div class="flz-box flz-85 flz-nospacer">
                    <h3>This should be a title</h3>
                    <h2>This should be the year | This should be the department | This should be the tutor</h2>
                </div>
                <div class="flz-box flz-10 flz-nospacer">
                    <button @click="ok = !ok">Show</button>
                </div>
            </div>
            <div v-show="ok" class="flz-box flz-100 article flz-nospacer">
                <div class="flz-box flz-5 flz-nospacer">
                    <p></p>
                </div>
                <div class="flz-box flz-60 flz-nospacer contentArticle">
                    <h2>Zusammenfassung {{test1}} - {{diploma.Title}} ({{diploma.id}})</h2>
                    <p>
                        Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor
                        invidunt
                        ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et
                        justo
                        duo
                        dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum
                        dolor
                        sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy
                        eirmod
                        tempor
                        invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et
                        accusam
                        et
                        justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est
                        Lorem
                        ipsum dolor sit amet.
                    </p>
                </div>
                <div class="flz-box flz-30 flz-nospacer contentArticle">
                    <h2>Authoren</h2>
                    <p>
                        Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor
                        invidunt
                        ut labore et dolore magna aliquyam erat, sed diam voluptua.
                    </p>
                    <p>
                        <button>View Details</button>
                    </p>
                </div>
                <div class="flz-box flz-5 flz-nospacer">
                    <p></p>
                </div>
            </div>
        </div>
        <div class="flz-box flz-nospacer">
            <div class="flz-box flz-nospacer flz-5">
                <p></p>
            </div>
            <div class="flz-box flz-95 flz-nospacer">
                <p>
                    <span>Icon1</span>
                    <span>Tag1</span>
                    <span>Icon2</span>
                    <span>Tag2</span>
                    <span>Icon3</span>
                    <span>Tag3</span>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['test1','diploma'],
        data() {
            return {
                ok: false
            }
        }
    }
</script>

<style scoped>

</style>