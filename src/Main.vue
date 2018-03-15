<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<template>
    <div id="main" class="flz-box flz-75">
        <button v-show="detailVisible" @click="onBackToList">Back to list</button>
        <button v-show="!detailVisible" @click="onCreateDiploma">Create New</button>
        <div class="flz-box flz-nospacer">
            <div v-if="!detailVisible" class="flz-box flz-nospacer">
                <div class="searching flz-nospacer">
                    <div class="flz-box flz-20 flz-nospacer">
                        <h1>Diplomarbeiten</h1>
                    </div>
                    <div class="flz-box flz-60 flz-nospacer">
                        <input v-model="search" @change="onSearchDiploma" placeholder="search..">
                    </div>
                    <div class="flz-box flz-20 flz-nospacer">
                        <a @click="extendedFilter = !extendedFilter" v-if="extendedFilter === false">Erweiterte
                            Suche</a>
                        <a @click="extendedFilter = !extendedFilter" v-if="extendedFilter === true">Verstecke Erweiterte
                            Suche</a>
                    </div>
                    <div v-if="extendedFilter === true" class="flz-box flz-nospacer">
                        <div class="flz-box flz-20 flz-nospacer">
                            <input type="text" v-model="searchedYear">
                        </div>
                        <div class="flz-box flz-20 flz-nospacer">
                            <multiselect
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
                        <div class="flz-box flz-20 flz-nospacer">
                            <multiselect
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
                        <div class="flz-box flz-20 flz-nospacer">
                            <multiselect
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
                        <div class="flz-box flz-20 flz-nospacer">
                            <multiselect
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
                        <button @click="onExtendedFilter">Erweiterte Sucheinstellungen aktivieren</button>
                    </div>
                </div>
                <div v-if="this.diplomaList.length > 0">
                    <div v-for="diploma in diplomaList">
                        <app-content :diploma="diploma"
                                     @onSelectDiploma="onSelectDiploma($event)">
                        </app-content>
                    </div>
                </div>
            </div>
            <div v-else-if="detailVisible" class="flz-box flz-nospacer border">
                <app-details :diploma="selectedDiploma"
                             @onDeleteDiploma="onDeleteDiploma($event)"
                             @onCancelCreateDiploma="onCancelCreateDiploma">
                </app-details>
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
                this.selectedDiploma = diploma;
                this.detailVisible = true;
            },
            onBackToList() {
                this.detailVisible = false;
            },
            onCreateDiploma() {
                this.selectedDiploma = {
                    "id": null,
                    "title": "",
                    "authors": [],
                    "tutors": [],
                    "departments": [],
                    "year": "",
                    "upload": "",
                    "summary": [],
                    "notes": [],
                    "attachments": "",
                    "tags": []
                };
                this.detailVisible = true;
            },
            onSearchDiploma() {
                axios.post('/diplomarbeitsarchiv/api/diplomarbeiten', this.search)
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
                axios.post('/diplomarbeitsarchiv/api/diplomarbeiten', this.searchedDiploma)
                    .then(response => {
                        console.log(this.searchedDiploma)
                        console.log(response)
                    })
                    .catch(error => {
                        console.log(error)
                    })
            },
            onDeleteDiploma(e) {
                axios.post('/diplomarbeitsarchiv/api/diplomarbeiten', this.selectedDiploma)
                    .then(function (response) {
                        console.log(response);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                this.diplomaList.splice((e - 1), 1);
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
                    this.diplomaList = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            axios.get('/diplomarbeitsarchiv/api/authors')
                .then(response => {
                    // JSON responses are automatically parsed.
                    this.optionsAuthors = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            axios.get('/diplomarbeitsarchiv/api/tutors')
                .then(response => {
                    // JSON responses are automatically parsed.
                    this.optionsTutors = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            axios.get('/diplomarbeitsarchiv/api/departments')
                .then(response => {
                    // JSON responses are automatically parsed.
                    this.optionsDepartments = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            axios.get('/diplomarbeitsarchiv/api/tags')
                .then(response => {
                    // JSON responses are automatically parsed.
                    this.optionsTags = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    }
</script>
<style scoped>
</style>