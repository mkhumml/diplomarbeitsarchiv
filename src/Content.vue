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
                        <h2>{{diploma.year}} | {{showDepartments(diploma.departments)}} |
                            {{showTutors(diploma.tutors)}}</h2>
                    </div>
                    <div class="flz-box flz-10 flz-nospacer">
                        <button @dblclick="onViewDiploma" @click="collapsed = !collapsed">Show</button>
                    </div>
                </div>
                <div v-show="collapsed" class="flz-box flz-100 article flz-nospacer">
                    <div class="flz-box flz-5 flz-nospacer">
                        <p></p>
                    </div>
                    <div class="flz-box flz-60 flz-nospacer contentArticle">
                        <h2>Summary</h2>
                        <p>
                            {{diploma.summary}}
                        </p>
                    </div>
                    <div class="flz-box flz-30 flz-nospacer contentArticle">
                        <h2>Notes</h2>
                        <p>
                            {{diploma.notes}}
                        </p>
                        <p>
                            <button v-on:click="onViewDiploma">View Details</button>
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
                        {{showTags(this.diploma.tags)}}
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
            }
        },
        data() {
            return {
                collapsed: false
            }
        },
        methods: {
            onViewDiploma() {
                console.log("select " + this.diploma);
                this.$emit('onSelectDiploma', this.diploma);
            },
            showDepartments(departments) {
                let display = "";
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
                for (let i = 0; i < tutors.length; i++) {
                    display += tutors[i].firstname + " " + tutors[i].lastname + " "
                    if (i < (tutors.length - 1)) {
                        display += ""
                    }
                }
                return display
            },
            showTags(tags) {
                let display = "";
                for (let i = 0; i < tags.length; i++) {
                    display += tags[i].name + " "
                    if (i < (tags.length - 1)) {
                    }

                }
                return display
            },
        }
    }
</script>

<style scoped>

</style>