<template>
    <div id="main" class="flz-box flz-75">
        <button v-show="detailVisible" v-on:click="onBackToList">Back to list</button>
        <button v-show="!detailVisible" v-on:click="onCreateDiploma">Create New</button>
        <div class="flz-box">
            <div v-if="! detailVisible" class="flz-box flz-nospacer">
                <div class="searching flz-nospacer">
                    <div class="flz-box flz-20 flz-nospacer">
                        <h1>Diplomarbeiten</h1>
                    </div>
                    <div class="flz-box flz-60 flz-nospacer">
                        <input v-model="search" @change="onSearchDiploma" placeholder="search..">
                    </div>
                    <div class="flz-box flz-20 flz-nospacer">
                        <a href="#">Erweiterte Suche</a>
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
                diplomaList: [],
                detailVisible: false,
                searchedDiploma: [],
                searchedDiplomaResults: [],
                selectedDiploma: {}
            }
        },
        methods: {
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
                let key;
                let results = [];
                for (let i = 0; i <= (this.diplomaList.length - 1); i++) {
                    key = Object.values(this.diplomaList[i]);
                    if (((key.join()).indexOf(this.search) + 1) > 0) {
                        results.push(i);
                    }
                }
                this.searchedDiploma = results.join('');
                axios.post('/diplomarbeitsarchiv/api/diplomarbeiten', this.searchedDiploma)
                    .then(response => {
                        // TODO
                    });
                return this.searchedDiploma
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
        }
    }
</script>
<style scoped>
</style>