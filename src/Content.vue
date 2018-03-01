<template>
    <div class="flz-box content">
        <div class="flz-box flz-nospacer">
            <div class="flz-box flz-nospacer">
                <div class="flz-box flz-nospacer">
                    <div class="flz-box flz-5 flz-nospacer">
                        <img class="icon" src="images/Download.jpeg"/>
                    </div>
                    <div class="flz-box flz-85 flz-nospacer">
                        <h3>{{diploma.title}}</h3>
                        <h2>{{diploma.year}} | {{showDepartments(diploma.departments)}} | {{showTutors(diploma.tutors)}}</h2>
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
                        <h2>{{diploma.summary}}</h2>
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
                        <h2>{{diploma.author}}</h2>
                        <p>
                            Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor
                            invidunt
                            ut labore et dolore magna aliquyam erat, sed diam voluptua.
                        </p>
                        <p>
                            <button v-on:click="changeHide">View Details</button>
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
    </div>
</template>

<script>
    export default {
        props: {
            diploma: {
                type: Object,
                required: true
            },
            hide: {
                type: Boolean,
                required: true
            }
        },
        data() {
            return {
                ok: false,
                key: 0
            }
        },
        methods: {
            changeHide() {
                this.hide = !this.hide
                this.$emit('changeChide', this.hide)
                this.key = this.diploma.id
                this.$emit('detailKey', this.key)
            },
            showDepartments(departments) {
                let display = "";
                /*for (let department of departments) {
                    display += department.name + ", ";
                } */
                for (let i = 0; i < departments.length; i++) {
                    display += departments[i].name;
                    if (i < (departments.length - 1)) {
                        display += ", "
                    }
                }
                return display
            },
            showTutors(tutors) {
                let display = "";
                for(let i = 0; i<tutors.length;i++) {
                    display += tutors[i].firstname + " "
                    if (i < (tutors.length -1)) {
                        display += ""
                    }
                }
                return display
            }
        },
    }
</script>

<style scoped>

</style>