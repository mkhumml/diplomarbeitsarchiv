<template>
    <div class="flz-box flz-nospacer">
        <!--
        compact display of diploma data
        shows title, departments, year, tutors
        icon toggle for more information (collapsed)
        -->
        <div class="flz-box flz-nospacer">
            <div class="flz-box flz-5 flz-10-lte-m">
                <div class="icon-file-text-o"></div>
            </div>
            <div class="flz-box flz-85 flz-80-lte-m flz-80-gte-m">
                <h2 @click="onViewDiploma">{{diploma.title}}</h2>
                <p>{{showDepartments(diploma.departments)}} | {{diploma.year}} | {{showTutors(diploma.tutors)}}</p>
            </div>
            <div class="flz-box flz-10">
                <p>
                <span v-show="!collapsed" class="icon-chevron-down" title="Mehr Anzeigen"
                      @click="collapsed = !collapsed"></span>
                    <span v-show="collapsed" class="icon-chevron-up" title="Weniger Anzeigen"
                          @click="collapsed = !collapsed"></span>
                </p>
            </div>
        </div>
        <!--
        display of the summary and notes, only if collapsed
        possibility to view details (button) when loggedIn = true
        -->
        <div v-show="collapsed" class="flz-box flz-100">
            <div class="flz-box flz-5 flz-10-lte-m flz-nospacer-gte-m">
                <p></p>
            </div>
            <div class="flz-box flz-60 flz-55-lte-m flz-90-lte-s flz-nospacer contentArticle">
                <h3>Zusammenfassung</h3>
                <p>
                    {{diploma.summary}}
                </p>
            </div>
            <div class="flz-box flz-5 flz-10-lte-m flz-nospacer-gte-m">
                <p class="flz-nospacer"></p>
            </div>
            <div class="flz-box flz-35-gte-m flz-90-lte-s flz-nospacer contentArticle">
                <h3>Notizen</h3>
                <p>
                    {{diploma.notes}}
                </p>
                <p>
                    <button v-show="loggedIn" v-on:click="onViewDiploma">Details ansehen</button>
                </p>
            </div>
            <div class="flz-box flz-5 flz-hide-lte-s flz-nospacer">
                <p></p>
            </div>
        </div>
        <!--
        tags get displayed with an icon
        div/p tags for framework spacers
        -->
        <div class="flz-box flz-nospacer">
            <div class="flz-box flz-5 flz-10-lte-m flz-clear">
                <p>

                </p>
            </div>
            <div class="flz-box flz-85 flz-80-lte-m">
                <p>
            <span v-for="tag in this.diploma.tags">
                <span class="icon-tag"></span> {{tag.name}}
            </span>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        //property diploma gets declared
        props: {
            diploma: {
                type: Object,
                required: true
            },
            loggedIn: {
                type: Boolean
            }
        },
        data() {
            return {
                collapsed: false
            }
        },
        methods: {
            //emit event to display detail page
            onViewDiploma() {
                console.log("select " + this.diploma);
                this.$emit('onSelectDiploma', this.diploma);
            },
            //function to iterate through the department list
            showDepartments(departments) {
                let display = "";
                if(departments) {
                    for (let i = 0; i < departments.length; i++) {
                        display += departments[i].name;
                        if (i < (departments.length - 1)) {
                            display += ", "
                        }
                    }
                }
                return display;
            },
            //function to iterate through the tutor list
            showTutors(tutors) {
                let display = "";
                if(tutors) {
                    for (let i = 0; i < tutors.length; i++) {
                        display += tutors[i].firstname + " " + tutors[i].lastname + " "
                        if (i < (tutors.length - 1)) {
                            display += " , "
                        }
                    }
                }
                return display
            }
        }
    }
</script>

<style scoped>

</style>