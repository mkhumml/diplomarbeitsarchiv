<template>
    <div class="flz-box flz-nospacer">
        <div class="flz-box flz-nospacer">
            <div class="flz-box flz-5 flz-10-lte-m">
                <div class="icon-file-text-o"></div>
            </div>
            <div class="flz-box flz-85 flz-80-lte-m">
                <h2>{{diploma.title}}</h2>
                <h3>{{diploma.year}} | {{showDepartments(diploma.departments)}} |
                    {{showTutors(diploma.tutors)}}</h3>
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
        <div v-show="collapsed" class="flz-box flz-100">
            <div class="flz-box flz-5 flz-nospacer">
                <p></p>
            </div>
            <div class="flz-box flz-60 flz-nospacer contentArticle">
                <h3>Zusammenfassung</h3>
                <p>
                    {{diploma.summary}}
                </p>
            </div>
            <div class="flz-box flz-30 flz-nospacer contentArticle">
                <h3>Notizen</h3>
                <p>
                    {{diploma.notes}}
                </p>
                <p>
                    <button v-on:click="onViewDiploma">Details ansehen</button>
                </p>
            </div>
            <div class="flz-box flz-5 flz-nospacer">
                <p></p>
            </div>
        </div>
        <div class="flz-box flz-5 flz-10-lte-m flz-clear">
            <p>

            </p>
        </div>
        <div class="flz-box flz-95 flz-90-lte-m">
            <p>
            <span v-for="tag in this.diploma.tags">
                <span class="icon-tag"></span> {{tag.name}}
            </span>
            </p>
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