<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style src="../styles/vue-multiselect-override.min.css"></style>
<template>
    <div id="main">
        <div v-show="detailVisible" class="flz-box flz-nospacer">
            <div class="flz-box flz-70 flz-nospacer">
                <h1>Diplomarbeit</h1>
            </div>
            <div class="flz-box flz-30">
                <span class="icon-home" title="Startseite"
                      @click="onBackToList"></span>
            </div>
        </div>
        <div class="flz-box flz-nospacer" v-if="!detailVisible">
            <div class="flz-box flz-form flz-nospacer searching">
                <div class="flz-box flz-nospacer">
                    <div class="flz-box flz-70 flz-100-lte-s flz-nospacer">
                        <div class="flz-box flz-30 flz-100-lte-s
                             flz-nospacer">
                            <h1>Diplomarbeiten</h1>
                        </div>
                        <div v-if="!extendedFilter" class="flz-box flz-70
                            flz-100-lte-s flz-nospacer-gte-m">
                            <input v-model="search"
                                   @change="onSearchDiploma"
                                   placeholder="Suchen ...">
                        </div>
                    </div>
                    <div class="flz-box flz-30 flz-100-lte-s flz-nospacer
                         toolbar">
                        <div class="flz-box">
                            <a @click="extendedFilter = !extendedFilter"
                               v-if="!extendedFilter">Erweiterte
                                Suche öffnen</a>
                            <a @click="extendedFilter = !extendedFilter"
                               v-if="extendedFilter">
                                Erweiterte Suche schließen</a>
                        </div>
                        <div class="iconbar">
                            <span class="icon-plus"
                                  title="Neue Diplomarbeit anlegen"
                                  v-show="!detailVisible"
                                  @click="onBeforeCreateDiploma"></span>
                        </div>
                    </div>
                </div>
                <div v-if="extendedFilter" class="flz-box flz-100
                     flz-nospacer">
                    <div class="flz-box flz-nospacer flz-50">
                        <div class="flz-box">
                            <label for="authors">Verfasser</label>
                            <multiselect
                                    id="authors"
                                    v-model="searchedAuthors"
                                    :custom-label="showAuthor"
                                    :close-on-select="true"
                                    :hide-selected="true"
                                    :multiple="true"
                                    :options="optionsAuthors"
                                    selectLabel=""
                                    track-by="id">
                            </multiselect>
                        </div>
                        <div class="flz-box">
                            <label for="tutors">Betreuer</label>
                            <multiselect
                                    id="tutors"
                                    v-model="searchedTutors"
                                    :custom-label="showTutor"
                                    :close-on-select="true"
                                    :hide-selected="true"
                                    :multiple="true"
                                    :options="optionsTutors"
                                    selectLabel=""
                                    track-by="id">
                            </multiselect>
                        </div>
                        <div class="flz-box">
                            <label for="departments">Abteilung</label>
                            <multiselect
                                    id="departments"
                                    label="name"
                                    v-model="searchedDepartments"
                                    :close-on-select="true"
                                    :hide-selected="true"
                                    :multiple="true"
                                    :options="optionsDepartments"
                                    selectLabel=""
                                    track-by="id">
                            </multiselect>
                        </div>
                    </div>
                    <div class="flz-box flz-50 flz-nospacer">
                        <div class="flz-box">
                            <label for="tags">Tags</label>
                            <multiselect
                                    id="tags"
                                    label="name"
                                    v-model="searchedTags"
                                    :close-on-select="true"
                                    :hide-selected="true"
                                    :multiple="true"
                                    :options="optionsTags"
                                    selectLabel=""
                                    track-by="id">
                            </multiselect>
                        </div>
                        <div class="flz-box">
                            <label for="year">Erstellungsjahr</label>
                            <input id="year" type="text"
                                   v-model="searchedYear">
                        </div>
                    </div>
                    <div class="flz-box">
                        <button @click="onExtendedFilter">Erweiterte Suche
                            starten
                        </button>
                        <button @click="onResetExtendedFilter">Erweiterte
                            Sucheinstellungen zurücksetzen
                        </button>
                    </div>
                </div>
            </div>
            <div class="flz-box" v-if="this.diplomaList.length > 0">
                <div class="flz-box content"
                     v-for="diploma in diplomaList">
                    <app-content :diploma="diploma"
                                 @onSelectDiploma="onSelectDiploma($event)">
                    </app-content>
                </div>
            </div>
        </div>
        <app-details v-else-if="detailVisible"
                     class="flz-box" :diploma="selectedDiploma"
                     @onCreateDiploma="onCreateDiploma($event)"
                     @onDeleteDiploma="onDeleteDiploma($event)"
                     @onCancelCreateDiploma="onCancelCreateDiploma">
        </app-details>
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
        props: {
            loggedIn: {
                type: Boolean,
                required: true
            }
        },
        data() {
            return {
                search: "",
                searchedDiploma: [],
                diplomaList: [],
                detailVisible: false,
                selectedDiploma: {},
                optionsAuthors: [],
                optionsTutors: [],
                optionsDepartments: [],
                optionsTags: [],
                extendedFilter: false,
                searchedAuthors: [],
                searchedTutors: [],
                searchedDepartments: [],
                searchedTags: [],
                searchedYear: ""
            }
        },
        methods: {
            showAuthor(author) {
                return `${author.firstname} ${author.lastname}`;
            },
            showTutor(tutor) {
                return `${tutor.firstname} ${tutor.lastname}`;
            },
            onSelectDiploma(diploma) {
                if (this.loggedIn === true) {
                    this.selectedDiploma = diploma;
                    this.detailVisible = true;
                } else {
                    alert("Bitte Melden Sie sich an!")
                }

            },
            onBackToList() {
                this.detailVisible = false;
            },
            onBeforeCreateDiploma() {
                if (this.loggedIn === true) {
                    this.selectedDiploma = {
                        "id": null,
                        "title": "",
                        "authors": [],
                        "tutors": [],
                        "departments": [],
                        "year": "",
                        "upload": "",
                        "summary": "",
                        "notes": "",
                        "attachments": [],
                        "tags": []
                    };
                    this.detailVisible = true;
                } else {
                    alert("Bitte Melden Sie sich an!")
                }
            },
            onSearchDiploma() {
                axios.post('/diplomarbeitsarchiv/api/search', {
                    name: this.search
                })
                    .then(response => {
                        this.diplomaList = response.data;
                    });
            },
            onExtendedFilter() {
                this.searchedDiploma = {
                    "id": null,
                    "authors": [],
                    "tutors": [],
                    "departments": [],
                    "year": "",
                    "tags": []
                };
                this.searchedDiploma.authors.push(this.searchedAuthors);
                this.searchedDiploma.tutors.push(this.searchedTutors);
                this.searchedDiploma.departments.push(this.searchedDepartments);
                this.searchedDiploma.tags.push(this.searchedTags);
                this.searchedDiploma.year = this.searchedYear;
                axios.post('/diplomarbeitsarchiv/api/extendedFilter', this.searchedDiploma)
                    .then(response => {
                        console.log(this.searchedDiploma)
                        console.log(response)
                    })
                    .catch(error => {
                        console.log(error)
                    })
            },
            onResetExtendedFilter() {
                this.searchedAuthors = null,
                    this.searchedTutors = null,
                    this.searchedDepartments = null,
                    this.searchedTags = null,
                    this.searchedYear = ""
            },
            onCreateDiploma(diploma) {
                // Add to list
                this.diplomaList.splice(0, 0, diploma);
            },
            onDeleteDiploma(diploma) {
                // Remove from list
                this.diplomaList.splice(this.diplomaList.indexOf(diploma), 1);
                this.detailVisible = false;
            },
            onCancelCreateDiploma() {
                this.detailVisible = false;
            }
        },
        beforeCreate() {
            // Get initial list of diplomas
            axios.get('/diplomarbeitsarchiv/api/diplomarbeiten')
                .then(response => {
                    console.log(response.data)
                    this.diplomaList = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            axios.get('/diplomarbeitsarchiv/api/authors')
                .then(response => {
                    this.optionsAuthors = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            axios.get('/diplomarbeitsarchiv/api/tutors')
                .then(response => {
                    this.optionsTutors = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            axios.get('/diplomarbeitsarchiv/api/departments')
                .then(response => {
                    this.optionsDepartments = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            axios.get('/diplomarbeitsarchiv/api/tags')
                .then(response => {
                    this.optionsTags = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        mounted() {
            axios.get('/diplomarbeitsarchiv/api/diplomarbeiten')
                .then(response => {
                    console.log(response.data)
                    this.diplomaList = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    }
</script>
<style scoped>
</style>