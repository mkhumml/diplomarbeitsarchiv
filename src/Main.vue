<!--
adding multiselect styles
adding multiselect override styles
-->
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style src="../styles/vue-multiselect-override.min.css"></style>
<template>
    <div id="main">
        <!--
        Div is always rendered due to v-show attribute
        displays the headline of diploma detail page and the home icon
        -->
        <div v-show="detailVisible" class="flz-box flz-nospacer">
            <div class="flz-box flz-70 flz-nospacer">
                <h1>Diplomarbeit</h1>
            </div>
            <div class="flz-box flz-30">
                <span class="icon-home" title="Startseite"
                      @click="onBackToList"></span>
            </div>
        </div>
        <!--
        diploma list container, initial rendering starts here due to 'detailVisible' is initial false
        -->
        <div class="flz-box flz-nospacer" v-if="!detailVisible">
            <!--
            searching display
            -->
            <div class="flz-box flz-form flz-nospacer searching">
                <div class="flz-box flz-nospacer">
                    <div class="flz-box flz-70 flz-100-lte-s flz-nospacer">
                        <!--
                        header of the diploma list
                        -->
                        <div class="flz-box flz-30 flz-100-lte-s
                             flz-nospacer">
                            <h1>Diplomarbeiten</h1>
                        </div>
                        <!--
                        title search input field
                        -->
                        <div v-if="!extendedFilter" class="flz-box flz-70
                            flz-100-lte-s flz-nospacer-gte-m">
                            <input v-model="search"
                                   @change="onSearchDiploma"
                                   placeholder="Suchen ...">
                        </div>
                    </div>
                    <div class="flz-box flz-30 flz-100-lte-s flz-nospacer
                         toolbar">
                        <!--
                        extended search toggle buttons
                        -->
                        <div class="flz-box">
                            <a @click="extendedFilter = !extendedFilter"
                               v-if="!extendedFilter">Erweiterte
                                Suche öffnen</a>
                            <a @click="extendedFilter = !extendedFilter"
                               v-if="extendedFilter">
                                Erweiterte Suche schließen</a>
                        </div>
                        <!--
                        creating new diploma icon
                        -->
                        <div class="iconbar" v-show="loggedIn">
                            <span class="icon-plus"
                                  title="Neue Diplomarbeit anlegen"
                                  v-show="!detailVisible"
                                  @click="onBeforeCreateDiploma"></span>
                        </div>
                    </div>
                </div>
                <!--
                extended search input form, only rendered when needed
                contains multiselect options for authors,tutors,departments,tags and an input field for the year
                under progress in backend(api)
                at the moment only works with the tag/year filter
                -->
                <div v-if="extendedFilter" class="flz-box flz-100
                     flz-nospacer">
                    <div class="flz-box flz-nospacer flz-50 flz-100-lte-m">
                        <div class="flz-box">
                            <label for="authors">Verfasser</label>
                            <!--
                            multiselect component from npm
                            track-by determines how the selected list is displayed
                            v-model binds the different selections
                            :hide-selected hides every selected value of the options list
                            :close-on-select closes everytime a value has been confirmed
                            :custom-label is needed for displaying firstname/lastname
                            :options binds every list item from the parameter that is in the database to this multiselect
                            -->
                            <multiselect
                                    id="authors"
                                    placeholder="Wählen Sie aus"
                                    selectLabel=""
                                    track-by="id"
                                    v-model="searchedAuthors"
                                    :custom-label="showAuthor"
                                    :close-on-select="true"
                                    :hide-selected="true"
                                    :multiple="true"
                                    :options="optionsAuthors">
                            </multiselect>
                        </div>
                        <div class="flz-box">
                            <label for="tutors">Betreuer</label>
                            <multiselect
                                    id="tutors"
                                    placeholder="Wählen Sie aus"
                                    selectLabel=""
                                    track-by="id"
                                    v-model="searchedTutors"
                                    :custom-label="showTutor"
                                    :close-on-select="true"
                                    :hide-selected="true"
                                    :multiple="true"
                                    :options="optionsTutors">
                            </multiselect>
                        </div>
                        <div class="flz-box">
                            <label for="departments">Abteilung</label>
                            <multiselect
                                    id="departments"
                                    label="name"
                                    placeholder="Wählen Sie aus"
                                    selectLabel=""
                                    track-by="id"
                                    v-model="searchedDepartments"
                                    :close-on-select="true"
                                    :hide-selected="true"
                                    :multiple="true"
                                    :options="optionsDepartments">
                            </multiselect>
                        </div>
                    </div>
                    <div class="flz-box flz-50 flz-100-lte-m flz-nospacer">
                        <div class="flz-box">
                            <label for="tags">Tags</label>
                            <multiselect
                                    id="tags"
                                    label="name"
                                    placeholder="Wählen Sie aus"
                                    selectLabel=""
                                    track-by="id"
                                    v-model="searchedTags"
                                    :close-on-select="true"
                                    :hide-selected="true"
                                    :multiple="true"
                                    :options="optionsTags">
                            </multiselect>
                        </div>
                        <div class="flz-box">
                            <label for="year">Erstellungsjahr</label>
                            <input id="year" type="text"
                                   v-model="searchedYear">
                        </div>
                    </div>
                    <!--
                    start extended search or reset it
                    -->
                    <div class="flz-box flz-nospacer-lte-m">
                        <div class="flz-box flz-50-gte-l flz-nospacer-gte-l">
                            <button @click="onExtendedFilter">Erweiterte Suche
                                starten
                            </button>
                        </div>
                        <div class="flz-box flz-50-gte-l flz-nospacer-gte-l">
                            <button @click="onResetExtendedFilter">Erweiterte
                                Sucheinstellungen zurücksetzen
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!--
            checking if the list is filled
            rendering through the list of diplomas
            bind every object to a different content component
            event listener for rendering the detail page
            -->
            <div class="flz-box" v-if="this.diplomaList.length > 0">
                <div class="flz-box content"
                     v-for="diploma in diplomaList">
                    <app-content :diploma="diploma"
                                 @onSelectDiploma="onSelectDiploma($event)"
                                 :loggedIn="loggedIn">
                    </app-content>
                </div>
            </div>
            <!--
            if the diploma list is empty, a message gets displayed
            -->
            <div v-if="this.diplomaList.length == 0" class="flz-box">
                <div class="flz-box content">
                    <p>Keine Diplomarbeiten gefunden.</p>
                </div>
            </div>
        </div>
        <!--
        details component rendered conditionally
        binding the selected diploma from the list
        listening to different events to react on different types of actions
        -->
        <app-details v-else-if="detailVisible"
                     class="flz-box" :diploma="selectedDiploma"
                     @onCreateDiploma="onCreateDiploma($event)"
                     @onDeleteDiploma="onDeleteDiploma($event)"
                     @onCancelCreateDiploma="onCancelCreateDiploma">
        </app-details>
    </div>
</template>
<script>
    //importing components
    import Content from './Content.vue'
    import Details from './Details.vue'

    export default {
        //declarate components
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
        //data function with variables
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
                searchedYear: "",
                catchError: "Da ist ein grober Fehler unterlaufen!"
            }
        },
        methods: {
            //display author in multiselect
            showAuthor(author) {
                return `${author.firstname} ${author.lastname}`;
            },
            //display tutor in multiselect
            showTutor(tutor) {
                return `${tutor.firstname} ${tutor.lastname}`;
            },
            //after a diploma gets selected, changing data to see detail information
            onSelectDiploma(diploma) {
                if (this.loggedIn === true) {
                    this.selectedDiploma = diploma;
                    this.detailVisible = true;
                } else {
                    //if not logged in, there is no detail page
                    alert("Bitte Melden Sie sich an!")
                }

            },
            //onClick function to get back to the home page
            onBackToList() {
                this.detailVisible = false;
            },
            //initialize new diploma
            onBeforeCreateDiploma() {
                if (this.loggedIn === true) {
                    this.selectedDiploma = {
                        "id": null,
                        "title": "",
                        "authors": [],
                        "tutors": [],
                        "departments": [],
                        "year": "",
                        "upload": null,
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
            //posting the search input to the api, returns result list
            onSearchDiploma() {
                axios.post('/diplomarbeitsarchiv/api/search', {
                    name: this.search
                })
                    .then(response => {
                        this.diplomaList = response.data;
                    })
                    .catch(error => {
                        alert(this.catchError)
                        console.log(error)
                    })
            },
            //extended Filters post to api, should return a result list
            onExtendedFilter() {
                this.searchedDiploma = {
                    "authors": [],
                    "tutors": [],
                    "departments": [],
                    "year": "",
                    "tags": []
                };
                this.searchedDiploma.authors = this.searchedAuthors;
                this.searchedDiploma.tutors = this.searchedTutors;
                this.searchedDiploma.departments = this.searchedDepartments;
                this.searchedDiploma.tags = this.searchedTags;
                this.searchedDiploma.year = this.searchedYear;
                axios.post('/diplomarbeitsarchiv/api/extendedFilter', this.searchedDiploma)
                    .then(response => {
                        this.diplomaList = response.data;
                    })
                    .catch(error => {
                        alert(this.catchError)
                        console.log(error)
                    })
            },
            //resetting extended filter selections
            onResetExtendedFilter() {
                this.searchedAuthors = null;
                this.searchedTutors = null;
                this.searchedDepartments = null;
                this.searchedTags = null;
                this.searchedYear = "";
                axios.get('/diplomarbeitsarchiv/api/diplomarbeiten')
                    .then(response => {
                        this.diplomaList = response.data;
                    })
                    .catch(function (error) {
                        alert(this.catchError)
                        console.log(error)
                    });
            },
            //when new diploma gets saved, it is added to the list
            onCreateDiploma(diploma) {
                // Add to list
                this.diplomaList.splice(0, 0, diploma);
            },
            //when diploma deletion is confirmed, it gets removed from the list
            onDeleteDiploma(diploma) {
                // Remove from list
                this.diplomaList.splice(this.diplomaList.indexOf(diploma), 1);
                this.detailVisible = false;
            },
            //cancel adding new diploma data
            onCancelCreateDiploma() {
                this.detailVisible = false;
            }
        },
        beforeCreate() {
            // Get initial list of diplomas
            axios.get('/diplomarbeitsarchiv/api/diplomarbeiten')
                .then(response => {
                    this.diplomaList = response.data;
                })
                .catch(function (error) {
                    alert(this.catchError)
                    console.log(error)
                });
            // get initial list of authors
            axios.get('/diplomarbeitsarchiv/api/authors')
                .then(response => {
                    this.optionsAuthors = response.data;
                })
                .catch(function (error) {
                    alert(this.catchError)
                    console.log(error)
                });
            // get initial list of tutors
            axios.get('/diplomarbeitsarchiv/api/tutors')
                .then(response => {
                    this.optionsTutors = response.data;
                })
                .catch(function (error) {
                    alert(this.catchError)
                    console.log(error)
                });
            // get initial list of departments
            axios.get('/diplomarbeitsarchiv/api/departments')
                .then(response => {
                    this.optionsDepartments = response.data;
                })
                .catch(function (error) {
                    alert(this.catchError)
                    console.log(error)
                });
            // get initial list of tags
            axios.get('/diplomarbeitsarchiv/api/tags')
                .then(response => {
                    this.optionsTags = response.data;
                })
                .catch(function (error) {
                    alert(this.catchError)
                    console.log(error)
                });
        }
    }
</script>
<style scoped>
</style>