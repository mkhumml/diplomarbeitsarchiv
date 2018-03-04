<template>
    <div id="main" class="flz-box flz-75">
        <button v-on:click="hide = !hide">asdf</button>
        <button v-on:click="addDiploma" v-on:changeChide="updateHide($event)" v-bind:hide="hide">Create New</button>
        <div v-if="diplomaLists && diplomaLists.length" class="flz-box">
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
                <div v-if="search === ''">
                    <div v-for="diplomalist in diplomaLists">
                        <app-content v-on:changeChide="updateHide($event)" v-bind:hide="hide"
                                     v-bind:diploma="diplomalist" v-on:detailKey="setDetailKey($event)">
                        </app-content>
                    </div>
                </div>
                <div v-else-if="search !== ''">
                    <div v-for="diplomalist in diplomaLists">
                        <app-content v-on:changeChide="updateHide($event)" v-bind:hide="hide"
                                     v-bind:diploma="diplomalist" v-on:detailKey="setDetailKey($event)">
                        </app-content>
                    </div>
                </div>
            </div>
            <div v-else-if="hide === false" class="flz-box flz-nospacer border">
                <app-details v-on:changeChide="updateHide($event)" v-bind:hide="hide"
                             v-bind:diploma="diplomaLists[this.idDetail - 1]" v-on:detailKey="setDetailKey($event)"
                             v-on:postUpdate="postSave($event)" v-on:deleteDiploma="deleteDiploma($event)">
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
                detailVisible: true,
                idDetail: 0,
                searchedDiploma: [],
                searchedDiplomaResults: [{}]
            }
        },
        methods: {
            updateHide: function (updatedHide) {
                this.detailVisible = updatedHide
            },
            setDetailKey: function (setDetailKey) {
                this.idDetail = setDetailKey
                console.log(this.idDetail)
            },
            postSave: function (e) {
                axios.post('http://localhost:80/diplomarbeitsarchiv/service.php', {
                    diploma: this.diplomaList[e - 1]
                })
                    .then(function (response) {
                        console.log(response);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            onCreateDiploma: function () {
                this.diplomaList.push({
                    "id": (this.diplomaList.length + 1),
                    "title": "diplomarbeitstitel" + (this.diplomaList.length + 1),
                    "author": "diplomarbeitsauthor" + (this.diplomaList.length + 1),
                    "tutor": "diplomarbeitstutor" + (this.diplomaList.length + 1),
                    "department": "fachabteilung" + (this.diplomaList.length + 1),
                    "year": "jahr" + (this.diplomaList.length + 1),
                    "upload": "diplomathesispdf" + (this.diplomaList.length + 1),
                    "summary": "loremipsum" + (this.diplomaList.length + 1),
                    "notes": "notes" + (this.diplomaList.length + 1),
                    "attachments": "attachments" + (this.diplomaList.length + 1),
                    "tags": "tags" + (this.diplomaList.length + 1)
                });
                alert("You have added new diploma data")
                axios.post('http://localhost:80/diplomarbeitsarchiv/service.php', {
                    diploma: this.diplomaList[this.diplomaList.length - 1]
                })
                    .then(function (response) {
                        console.log(response);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            onDeleteDiploma: function (e) {
                axios.post('http://localhost:80/diplomarbeitsarchiv/service.php', {
                    diploma: this.diplomaList[e - 1]
                })
                    .then(function (response) {
                        console.log(response);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                this.diplomaList.splice((e - 1), 1)
                this.detailVisible = !this.detailVisible
                alert("You have deleted your Diploma data")
            },
            onSearchDiploma: function () {
                var key
                var results = []
                for (var i = 0; i <= (this.diplomaList.length - 1); i++) {
                    key = Object.values(this.diplomaList[i])
                    if (((key.join()).indexOf(this.search) + 1) > 0) {
                        results.push(i);
                    }
                }
                this.searchedDiploma = results.join('')
                console.log(this.searchedDiploma)
                return this.searchedDiploma
            },
        },
        created: function () {
            axios.get('/diplomarbeitsarchiv/services.php')
                .then(response => {
                    // JSON responses are automatically parsed.
                    console.log(this.diplomaList);
                    this.diplomaList = response.data;
                    console.log(this.diplomaList);
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    }
</script>

<style scoped>
    this.diplomaLists.push({
    "id": (this.diplomaLists.length + 1),
    "title": "diplomarbeitstitel" + (this.diplomaLists.length + 1),
    "author": "diplomarbeitsauthor" + (this.diplomaLists.length + 1),
    "tutor": "diplomarbeitstutor" + (this.diplomaLists.length + 1),
    "department": "fachabteilung" + (this.diplomaLists.length + 1),
    "year": "jahr" + (this.diplomaLists.length + 1),
    "upload": "diplomathesispdf" + (this.diplomaLists.length + 1),
    "summary": "loremipsum" + (this.diplomaLists.length + 1),
    "notes": "notes" + (this.diplomaLists.length + 1),
    "attachments": "attachments" + (this.diplomaLists.length + 1),
    "tags": "tags" + (this.diplomaLists.length + 1)
    });
</style>