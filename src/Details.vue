<template>
    <div class="flz-box flz-form details">
        <div class="flz-box flz-66 flz-nospacer">
            <div class="flz-box">
                <h1>Title</h1>
                <input type="text" v-model="diploma.title" :readonly="readonly">
            </div>
            <div class="flz-box flz-50">
                <h1>Authors</h1>
                <multiselect v-model="diploma.authors"
                             :custom-label="showAuthor"
                             :close-on-select="true"
                             :disabled="readonly"
                             :hide-selected="true"
                             :multiple="true"
                             :options="optionsAuthors"
                             selectLabel=""
                             track-by="id"
                             :taggable="true"
                             @tag="addAuthor">
                </multiselect>
            </div>
            <div class="flz-box flz-50">
                <h1>Tutors</h1>
                <multiselect v-model="diploma.tutors"
                             :custom-label="showTutor"
                             :close-on-select="true"
                             :disabled="readonly"
                             :hide-selected="true"
                             :multiple="true"
                             :options="optionsTutors"
                             selectLabel=""
                             track-by="id"
                             :taggable="true"
                             @tag="addTutor">
                </multiselect>
            </div>
        </div>
        <div class="flz-box flz-33">
            <img src="images/Download.jpeg">
        </div>
        <div class="flz-box flz-50">
            <h1>Department</h1>
            <multiselect v-model="diploma.departments"
                         :close-on-select="true"
                         :disabled="readonly"
                         :hide-selected="true"
                         :multiple="true"
                         :options="optionsDepartments"
                         selectLabel=""
                         label="name"
                         track-by="id"
                         :taggable="true"
                         @tag="addDepartment">
            </multiselect>
        </div>
        <div class="flz-box flz-50 flz-nospacer">
            <div class="flz-box flz-33">
                <h1>Year</h1>
                <multiselect v-model="diploma.year"
                             :disabled="readonly"
                             :options="optionsYears"
                             selectLabel=""
                             track-by="id">
                </multiselect>
            </div>
            <div class="flz-box flz-66">
                <h1>Diplomathesis</h1>
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
                <app-upload :readonly="readonly">
                </app-upload>
            </div>
        </div>
        <div class="flz-box flz-33">
            <h1>Summary</h1>
            <textarea v-model="diploma.summary" :disabled="readonly">{{diploma.summary}}</textarea>
        </div>
        <div class="flz-box flz-33">
            <h1>Notes</h1>
            <textarea v-model="diploma.notes" :disabled="readonly">{{diploma.notes}}</textarea>
        </div>
        <div class="flz-box flz-33">
            <h1>Attachments</h1>
            <!-- FIXME Show links instead to be able to download the files -->
            <input :value="diploma.attachments" :readonly="readonly">
        </div>
        <div class="flz-box">
            <h1>Tags</h1>
            <multiselect v-model="diploma.tags"
                         :disabled="readonly"
                         :hide-selected="true"
                         :multiple="true"
                         :options="optionsTags"
                         :taggable="true"
                         label="name"
                         selectLabel=""
                         track-by="name"
                         @tag="addTag">
            </multiselect>
        </div>
        <div class="flz-box">
            <button v-show="readonly" v-on:click="onEdit">Edit</button>
            <button v-show="readonly" v-on:click="onDelete">Delete</button>
            <button v-show="! readonly" v-on:click="onSave">Save</button>
            <button v-show="! readonly" v-on:click="onCancel">Cancel</button>
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
                    notes: this.diploma.notes,
                    attachments: this.diploma.attachments,
                    tags: this.diploma.tags
                },
                optionsAuthors: [],
                optionsDepartments: [],
                optionsTags: [],
                optionsTutors: [],
                optionsYears: [
                    2018,
                    2017,
                    2016
                ],
                readonly: true,
            }
        },
        methods: {
            showAuthor(author) {
                return `${author.firstname} ${author.lastname}`;
            },
            showTutor(tutor) {
                return `${tutor.firstname} ${tutor.lastname}`;
            },
            setReadonly(readonly) {
                this.readonly = readonly;
            },
            addTag(tagName) {
                let tag = {id: null, name: tagName};
                this.optionsTags.push(tag);
                this.diploma.tags.push(tag);
            },
            addAuthor(authorName) {
                let parts = authorName.split(" ")
                if (parts.length <= 2) {
                    let author = {id: null, firstname: parts[0], lastname: parts[1]};
                    this.optionsAuthors.push(author);
                    this.diploma.authors.push(author);
                    console.log("successAddAuthor")
                }
                else if(parts.length > 2) {
                    console.log("You need to add firstname and lastname")
                }
            },
            addTutor(tutorName) {
                let parts = tutorName.split(" ")
                if (parts.length <= 2) {
                    let tutor = {id: null, firstname: parts[0], lastname: parts[1]};
                    this.optionsTutors.push(tutor);
                    this.diploma.tutors.push(tutor);
                    console.log("successAddTutor")
                }
                else if(parts.length > 2) {
                    console.log("You need to add firstname and lastname")
                }
            },
            addDepartment(departmentName) {
                let department = {id: null, name: departmentName};
                this.optionsDepartments.push(department);
                this.diploma.departments.push(department);
            },
            onCancel() {
                this.$emit('onCancelCreateDiploma');
                this.setReadonly(true);
                this.diploma.id = this.diplomaOrig.id;
                this.diploma.title = this.diplomaOrig.title;
                this.diploma.authors = this.diplomaOrig.authors;
                this.diploma.tutor = this.diplomaOrig.tutor;
                this.diploma.departments = this.diplomaOrig.department;
                this.diploma.year = this.diplomaOrig.year;
                this.diploma.upload = this.diplomaOrig.upload;
                this.diploma.summary = this.diplomaOrig.summary;
                this.diploma.notes = this.diplomaOrig.notes;
                this.diploma.attachments = this.diplomaOrig.attachments;
                this.diploma.tags = this.diplomaOrig.tags;
            },
            onEdit() {
                this.setReadonly(false);
            },
            onSave() {
                axios.post('/diplomarbeitsarchiv/api/diplomarbeiten/', this.diploma)
                    .then(response => {
                        this.diploma.title = response.data.title;
                        this.diploma.authors = response.data.authors;
                        this.diploma.tutors = response.data.tutors;
                        this.diploma.departments = response.data.departments;
                        this.diploma.year = response.data.year;
                        this.diploma.upload = response.data.upload;
                        this.diploma.summary = response.data.summary;
                        this.diploma.notes = response.data.notes;
                        this.diploma.attachments = response.data.attachments;
                        this.diploma.tags = response.data.tags;
                        this.setReadonly(true);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            onDelete() {
                axios.delete('/diplomarbeitsarchiv/api/diplomarbeiten/' + this.diploma.id)
                    .then(response => {
                        this.$emit('onDeleteDiploma', response.data)
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
        },
        created() {
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

            // In case of newly created diploma immediately turn on edit mode
            if (this.diploma.id === null) {
                this.setReadonly(false);
            }
        }
    }

</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped></style>