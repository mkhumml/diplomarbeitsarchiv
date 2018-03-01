<template>
    <div class="flz-box details">
        <div class="flz-box flz-66 flz-nospacer">
            <div class="flz-box">
                <h1>Title</h1>
                <input v-model="diploma.title" v-bind:readonly="!editonly">
            </div>
            <div class="flz-box flz-50">
                <h1>Authors</h1>
                <!--<input v-model="diploma.author" v-bind:readonly="!editonly">-->
                <multiselect v-model="selectedAuthors" :options="optionsAuthors" :readonly="!editonly"
                             :multiple="true" :close-on-select="false" :hide-selected="true"
                             :track-by="id" :custom-label="showAuthor" :clear-on-select="false" selectLabel=""></multiselect>
            </div>
            <div class="flz-box flz-50">
                <h1>Tutors</h1>
                <multiselect v-model="selectedTutors" :options="optionsTutors" :readonly="!editonly"
                             :multiple="true" :close-on-select="false" :hide-selected="true"
                             :track-by="id" :custom-label="showTutor" :clear-on-select="false"></multiselect>
            </div>
        </div>
        <div class="flz-box flz-33">
            <img src="images/Download.jpeg">
        </div>
        <div class="flz-box flz-50">
            <h1>Department</h1>
            <multiselect v-model="selectedDepartments" :options="optionsDepartments" :readonly="!editonly"
                         :multiple="true" :close-on-select="false" :hide-selected="true"
                         :track-by="id" :custom-label="showDepartment" :clear-on-select="false"></multiselect>
        </div>
        <div class="flz-box flz-50 flz-nospacer">
            <div class="flz-box flz-33">
                <h1>Year</h1>
                <input v-model="diploma.year" v-bind:readonly="!editonly">
            </div>
            <div class="flz-box flz-66">
                <h1>Diplomathesi</h1>
                <!--<vue-clip :options="options">
                    <template slot="clip-uploader-action">
                        <div class="uploader-action flz-nospacer">
                            <div class="dz-message flz-nospacer">Upload Pdf vhere</div>
                        </div>
                    </template>
                    <template slot="clip-uploader-body" scope="props">
                        <div class="uploader-files">
                            <div v-for="file in props.file">
                                <img v-bind:src="file.dataUrl"/>
                                <p>{{ file.name }} {{ file.status }}</p>
                            </div>
                        </div>
                    </template>
                </vue-clip>-->
                <app-upload></app-upload>
                <input v-model="diploma.upload" v-bind:readonly="!editonly">
            </div>
        </div>
        <div class="flz-box flz-33">
            <h1>Summary</h1>
            <input v-model="diploma.summary" v-bind:readonly="!editonly">
        </div>
        <div class="flz-box flz-33">
            <h1>Notes</h1>
            <input v-model="diploma.notes" v-bind:readonly="!editonly">
        </div>
        <div class="flz-box flz-33">
            <h1>Attachments</h1>
            <input v-model="diploma.attachments" v-bind:readonly="!editonly">
        </div>
        <div class="flz-box">
            <h1>Tags</h1>
            <multiselect v-model="tags" :options="optionsTags" :readonly="!editonly" :taggable="true"
                         @tag="pushTags" :multiple="true" :close-on-select="false" :hide-selected="true"
                         :clear-on-select="false"></multiselect>
        </div>
        <div class="flz-box">
            <button v-show="!editonly" v-on:click="changeEdit">Edit</button>
            <button v-show="!editonly" v-on:click="deleteDiploma">Delete</button>
            <button v-show="editonly" v-on:click="save">Save</button>
            <button v-show="editonly" v-on:click="reset">Cancel</button>
        </div>
    </div>
</template>

<script>
    import Upload from './Upload.vue'

    export default {
        components: {
            'app-upload': Upload
        },
        props: {
            diploma: {
                type: Object,
                required: true
            },
            editonly: {
                type: Boolean,
                required: true
            }
        },
        data() {
            return {
                diplomaOrig: {
                    id: this.diploma.id,
                    title: this.diploma.title,
                    authors: this.diploma.authors,
                    tutor: this.diploma.tutor,
                    department: this.diploma.departments,
                    year: this.diploma.year,
                    upload: this.diploma.upload,
                    summary: this.diploma.summary,
                    attachments: this.diploma.attachments,
                    tags: this.diploma.tags
                },
                selectedAuthors: this.diploma.authors,
                selectedDepartments: this.diploma.departments,
                selectedTags: this.diploma.tags,
                selectedTutors: this.diploma.tutor,
                optionsAuthors: [],
                optionsDepartments: [],
                optionsTags: [],
                optionsTutors: [],
            }
        },
        methods: {
            reset() {
                this.diploma.id = this.diplomaOrig.id;
                this.diploma.title = this.diplomaOrig.title;
                this.diploma.authors = this.diplomaOrig.authors;
                this.diploma.tutor = this.diplomaOrig.tutor;
                this.diploma.departments = this.diplomaOrig.department;
                this.diploma.year = this.diplomaOrig.year;
                this.diploma.upload = this.diplomaOrig.upload;
                this.diploma.summary = this.diplomaOrig.summary;
                this.diploma.attachments = this.diplomaOrig.attachments;
                this.diploma.tags = this.diplomaOrig.tags;
                this.changeEdit();
            },
            showAuthor(author) {
                return `${author.firstname} ${author.lastname}`;
            },
            showTutor(tutor) {
                return `${tutor.firstname} ${tutor.lastname}`;
            },
            showDepartment(department){
                return department.name;
            },
            changeEdit() {
                this.editonly = !this.editonly
            },
            pushTags(newTag) {
                this.optionsTags.push(newTag)
                this.tags.push(newTag)
                console.log(this.optionsTags)
                console.log(newTag)
            },
            save() {
                axios.post('/diplomarbeitsarchiv/api/diplomarbeiten/', this.diploma)
                    .then(response => {
                        console.log(response.data);
                        this.diploma.title = response.data.title;
                        this.changeEdit();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            deleteDiploma() {
                axios.delete('/diplomarbeitsarchiv/api/diplomarbeiten/' + this.diploma.id)
                    .then(response => {
                        this.$emit('deleteDiploma', response.data)
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
        },
        created: function () {
            console.log(this.diploma.authors)
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
        }
    }

</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style scoped>

</style>