<template>
    <div id="main" class="flz-box flz-75">
        <button v-on:click="hide = !hide">asdf</button>
        <button v-on:click="addDiploma" v-on:changeChide="updateHide($event)" v-bind:hide="hide">Create New</button>
        <div class="flz-box">
            <div v-if="hide" class="flz-box flz-nospacer">
                <div class="searching flz-nospacer">
                    <div class="flz-box flz-20 flz-nospacer">
                        <h1>Diplomarbeiten</h1>
                    </div>
                    <div class="flz-box flz-60 flz-nospacer">
                        <input v-model="search" @change="searchDiploma" placeholder="search..">
                    </div>
                    <div class="flz-box flz-20 flz-nospacer">
                        <a href="#">Erweiterte Suche</a>
                    </div>
                </div>
                <div v-if="this.diplomaLists.length > 0">
                    <div v-for="diplomalist in diplomaLists">
                        <app-content v-on:changeChide="updateHide($event)" v-bind:hide="hide"
                                     v-bind:diploma="diplomalist" v-on:detailKey="setDetailKey($event)">
                        </app-content>
                    </div>
                </div>
            </div>
            <div v-else-if="hide === false" class="flz-box flz-nospacer border">
                <app-details v-on:changeChide="updateHide($event)" v-bind:hide="hide"
                             v-bind:diploma="diplomaLists[this.idDetail - 1]"
                             v-bind:editonly="editonly"
                             v-on:detailKey="setDetailKey($event)" v-on:deleteDiploma="deleteDiploma($event)">
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
                diplomaLists: [],
                hide: true,
                idDetail: 0,
                searchedDiploma: [],
                searchedDiplomaResults: [],
                editonly: false
            }
        },
        methods: {
            updateHide: function (updatedHide) {
                this.hide = updatedHide
            },
            setDetailKey: function (setDetailKey) {
                this.idDetail = setDetailKey
                console.log(this.idDetail)
            },
            postSave: function (e) {
                axios.post('diplomarbeitsarchiv/diplomarbeiten', this.diplomaLists[e - 1])
                    .then(function (response) {
                        console.log(response);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            addDiploma: function () {
                this.diplomaLists.push({
                    "id": "",
                    "title": "",
                    "authors": "",
                    "tutors": "",
                    "department": "",
                    "year": "",
                    "upload": "",
                    "summary": "",
                    "notes": "",
                    "attachments": "",
                    "tags": ""
                });
                this.idDetail = this.diplomaLists.length;
                this.editonly = true;
                this.hide = !this.hide;
            },
            deleteDiploma: function (e) {
                axios.post('/diplomarbeitsarchiv/api/diplomarbeiten', this.diplomaLists[e - 1])
                    .then(function (response) {
                        console.log(response);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                this.diplomaLists.splice((e - 1), 1)
                this.hide = !this.hide
                alert("You have deleted your Diploma data")
            },
            searchDiploma: function () {
                var key
                var results = []
                for (var i = 0; i <= (this.diplomaLists.length - 1); i++) {
                    key = Object.values(this.diplomaLists[i])
                    if (((key.join()).indexOf(this.search) + 1) > 0) {
                        results.push(i);
                    }
                }
                this.searchedDiploma = results.join('')
                axios.post('/diplomarbeitsarchiv/api/diplomarbeiten', this.searchedDiploma)
                    .then(response => {
                    })
                return this.searchedDiploma
            },
        },
        beforeCreate: function () {
            axios.get('/diplomarbeitsarchiv/api/diplomarbeiten')
                .then(response => {
                    // JSON responses are automatically parsed.
                    this.diplomaLists = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    }
</script>
<style scoped>
</style>