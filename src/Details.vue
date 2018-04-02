<!--
adding multiselect styles
adding multiselect override styles
-->
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style src="../styles/vue-multiselect-override.min.css"></style>
<template>
    <!--
    Detail form of single diploma thesis
    -->
    <div class="flz-box flz-form flz-nospacer details">
        <div class="flz-box flz-nospacer">
            <!--
            required input fields title and year
            -->
            <div class="flz-box flz-70 flz-100-lte-xs">
                <label for="title">Titel*</label>
                <input id="title" type="text" v-model="diploma.title" :readonly="readonly">
                <p class="required flz-nospacer">{{errorTitle}}</p>
            </div>
            <div class="flz-box flz-30 flz-100-lte-xs">
                <label for="year">Jahr*</label>
                <input id="year" type="text" v-model="diploma.year" :readonly="readonly">
                <p class="required flz-nospacer">{{errorYear}}</p>
            </div>
        </div>
        <div class="flz-box">
            <label for="authors">Verfasser</label>
            <!--
            multiselect from npm
            placeholder is needed for entering firstname / lastname in right order ( the component doesnt support that kind of validation
            track-by lastname minimize mistakes by the component
            :disabled for edit validation
            :taggable offers the @tag listener
            @tag adds a function to add a new value to the list is executed
            -->
            <multiselect
                    id="authors"
                    placeholder="Vorname / Nachname"
                    track-by="lastname"
                    tagPlaceholder="Vorname / Nachname"
                    selectLabel=""
                    v-model="diploma.authors"
                    :close-on-select="true"
                    :custom-label="showAuthor"
                    :disabled="readonly"
                    :hide-selected="true"
                    :multiple="true"
                    :options="optionsAuthors"
                    :taggable="true"
                    @tag="addAuthor">
            </multiselect>
            <!--
            display of the error message
            -->
            <p class="flz-nospacer required">{{errorAuthor}}</p>
        </div>
        <div class="flz-box flz-nospacer">
            <div class="flz-box flz-50 flz-100-lte-xs">
                <label for="tutors">Betreuer</label>
                <multiselect
                        id="tutors"
                        placeholder="Vorname / Nachname"
                        selectLabel=""
                        tagPlaceholder="Vorname / Nachname"
                        track-by="lastname"
                        v-model="diploma.tutors"
                        :close-on-select="true"
                        :custom-label="showTutor"
                        :disabled="readonly"
                        :hide-selected="true"
                        :multiple="true"
                        :options="optionsTutors"
                        :taggable="true"
                        @tag="addTutor">
                </multiselect>
                <p class="flz-nospacer required">{{errorTutor}}</p>
            </div>
            <div class="flz-box flz-50 flz-100-lte-xs">
                <label for="department">Abteilung</label>
                <multiselect id="department"
                             label="name"
                             selectLabel=""
                             placeholder="Abteilung"
                             tagPlaceholder="Abteilung"
                             track-by="name"
                             v-model="diploma.departments"
                             :close-on-select="true"
                             :disabled="readonly"
                             :hide-selected="true"
                             :multiple="true"
                             :options="optionsDepartments"
                             :taggable="true"
                             @tag="addDepartment">
                </multiselect>
                <p class="flz-nospacer required">{{errorDepartment}}</p>
            </div>
        </div>
        <div class="flz-box flz-nospacer">
            <!--
            display of the upload input for the diploma pdf
            the original name of the file gets displayed, with a link refered to the storage in the server
            -->
            <div class="flz-box flz-50 flz-100-lte-xs">
                <label for="diplomarbeit">Diplomarbeit</label>
                <div v-if="this.diploma.upload !== null && this.diploma.upload.tmp_name"
                     class="flz-box attachments flz-nospacer">
                    <a v-bind:href="diploma.upload.tmp_name" target="_blank">{{diploma.upload.name}}</a>
                </div>
                <input id="diplomarbeit" type="file" id="file" value="" ref="diploma" v-on:change="onDiplomaSelected"
                       :disabled="readonly" v-show="!readonly"/>
            </div>
            <!--
            display of the attachment input (multiple)
            original names of the files get displayed
            because attachments are multiple, iteration through the list is needed
            not all files get downloaded, only zip/docx/pdf
            -->
            <div class="flz-box flz-50 flz-100-lte-xs">
                <label>Anhänge</label>
                <ul class="attachments flz-nospacer">
                    <li v-for="attachment in diploma.attachments">
                        <span v-if="attachment.tmp_name">
                            <a v-bind:href="attachment.tmp_name" target="_blank">{{attachment.name}}</a>
                        </span>
                    </li>
                </ul>
                <input type="file" id="files" value="" ref="attachments" multiple v-on:change="onAttachmentSelected"
                       :disabled="readonly" v-show="!readonly"/>
            </div>
        </div>
        <div class="flz-box flz-nospacer">
            <div class="flz-box flz-nospacer">
                <div class="flz-box flz-50 flz-100-lte-xs">
                    <label for="summary">Zusammenfassung</label>
                    <textarea id="summary" rows="10" v-model="diploma.summary"
                              :disabled="readonly">{{diploma.summary}}</textarea>
                </div>
                <div class="flz-box flz-50 flz-100-lte-xs">
                    <label for="notes">Notizen</label>
                    <textarea id="notes" rows="10" v-model="diploma.notes"
                              :disabled="readonly">{{diploma.notes}}</textarea>
                </div>
            </div>
        </div>
        <div class="flz-box">
            <label for="tag">Tags</label>
            <multiselect id="tag"
                         label="name"
                         selectLabel=""
                         placeholder="Tags"
                         tagPlaceholder="Tags"
                         track-by="name"
                         v-model="diploma.tags"
                         :close-on-select="true"
                         :disabled="readonly"
                         :hide-selected="true"
                         :multiple="true"
                         :options="optionsTags"
                         :taggable="true"
                         @tag="addTag">
            </multiselect>
            <p class="flz-nospacer required">{{errorTags}}</p>
        </div>
        <div class="flz-box">
            <button v-show="readonly" v-on:click="onEdit">Bearbeiten</button>
            <button v-show="readonly" v-on:click="onDelete">Löschen</button>
            <button v-show="! readonly" v-on:click="onSave">Speichern</button>
            <button v-show="! readonly" v-on:click="onCancel">Abbrechen</button>
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
                //copy of the diploma thesis to be able to reset the formular
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
                readonly: true,
                attachments: [],
                diplomaFile: "",
                errorAuthor: "",
                errorTutor: "",
                errorDepartment: "",
                errorTags: "",
                errorTitle: "",
                errorYear: "",
                errorMessage: "Bitte beachten Sie die geforderte Eingabe!"
            }
        },
        methods: {
            //display authors array
            showAuthor(author) {
                return `${author.firstname} ${author.lastname}`;
            },
            //display tutors array
            showTutor(tutor) {
                return `${tutor.firstname} ${tutor.lastname}`;
            },
            //toggle readonly
            setReadonly(readonly) {
                this.readonly = readonly;
            },
            //add new tag
            addTag(tagName) {
                let tag = {id: null, name: tagName};
                let parts = tagName.split(" ");
                if (parts.length > 1) {
                    this.errorTags = this.errorMessage;
                }
                else {
                    this.optionsTags.push(tag);
                    this.diploma.tags.push(tag);
                }
            },
            //add new author
            addAuthor(authorName) {
                let parts = authorName.split(" ")
                //checking for 2 parts, assuming that firstname/lastname is in order
                if (parts.length == 2 && parts[1].length > 0) {
                    let author = {id: null, firstname: parts[0], lastname: parts[1]};
                    this.optionsAuthors.push(author);
                    this.diploma.authors.push(author);
                    this.errorAuthor = "";
                }
                else {
                    this.errorAuthor = this.errorMessage;
                }

            },
            //add new tutor
            addTutor(tutorName) {
                let parts = tutorName.split(" ")
                //checking for 2 parts, assuming that firstname/lastname is in order
                if (parts.length == 2 && parts[1].length > 0) {
                    let tutor = {id: null, firstname: parts[0], lastname: parts[1]};
                    this.optionsTutors.push(tutor);
                    this.diploma.tutors.push(tutor);
                    this.errorTutor = "";
                }
                else {
                    this.errorTutor = this.errorMessage;
                }
            },
            //add new department
            addDepartment(departmentName) {
                let parts = departmentName.split(" ");
                if (parts.length > 1) {
                    this.errorDepartment = this.errorMessage;
                } else {
                    let department = {id: null, name: departmentName};
                    this.optionsDepartments.push(department);
                    this.diploma.departments.push(department);
                    this.errorDepartment = "";
                }
            },
            //reset formular on cancel
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
            //set edit mode
            onEdit() {
                this.setReadonly(false);
            },
            //on save function
            onSave() {
                //declare formData
                let formData = new FormData();
                //checking if the diploma data is new
                let wasNew = this.diploma.id === null;
                //checking for upload file
                if (this.diplomaFile !== null) {
                    formData.append("diplomaFile", this.diplomaFile);
                }
                //checking for attachment file
                if (this.attachments.length > 0) {
                    //adding attachments to formData
                    for (let i = 0; i < this.attachments.length; i++) {
                        formData.append('attachments[' + i + ']', this.attachments[i]);
                    }
                }
                // if required input fields are not empty
                if (this.diploma.title != "" && this.diploma.year != "") {
                    //diploma data is added to formData
                    formData.append("diploma", JSON.stringify(this.diploma));
                    axios.post('/diplomarbeitsarchiv/api/diplomarbeiten/', formData, {headers: {'Content-Type': 'multipart/form-data'}})
                        .then(response => {
                            //updating new saved files in the formular
                            this.diploma.id = response.data.id;
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
                            this.$refs.diploma.value = null;
                            this.$refs.attachments.value = null;
                            this.setReadonly(true);
                            this.errorTitle = "";
                            this.errorYear = "";
                            //new diploma gets added to list
                            if (wasNew) {
                                this.$emit('onCreateDiploma', this.diploma);
                            }
                        })
                        .catch(function (error) {
                            alert(error)
                        });
                }
                //checking for required input
                else if (this.diploma.title == "" && this.diploma.year == "") {
                    this.errorYear = "Bitte geben Sie das Jahr an!";
                    this.errorTitle = "Bitte geben Sie den Titel an!";
                }
                else if (this.diploma.title == "") {
                    this.errorTitle = "Bitte geben Sie den Titel an!";
                    this.errorYear = "";
                }
                else if (this.diploma.year == "") {
                    this.errorYear = "Bitte geben Sie das Jahr an!";
                    this.errorTitle = "";
                }
            },
            // two way confirm to delete data
            onDelete() {
                if (confirm('Wollen Sie diese Diplomarbeit wirklich löschen?')) {
                    axios.delete('/diplomarbeitsarchiv/api/diplomarbeiten/' + this.diploma.id)
                        .then(response => {
                            this.$emit('onDeleteDiploma', this.diploma)
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }
            },
            //selected upload file
            onDiplomaSelected: function () {
                this.diplomaFile = this.$refs.diploma.files[0];
            },
            //selected attachments files
            onAttachmentSelected: function () {
                this.attachments = this.$refs.attachments.files;
            }
        },
        mounted() {
            //get authors from database
            axios.get('/diplomarbeitsarchiv/api/authors')
                .then(response => {
                    // JSON responses are automatically parsed.
                    this.optionsAuthors = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            //get tutors from database
            axios.get('/diplomarbeitsarchiv/api/tutors')
                .then(response => {
                    // JSON responses are automatically parsed.
                    this.optionsTutors = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            //get departments from database
            axios.get('/diplomarbeitsarchiv/api/departments')
                .then(response => {
                    // JSON responses are automatically parsed.
                    this.optionsDepartments = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            //get tags from database
            axios.get('/diplomarbeitsarchiv/api/tags')
                .then(response => {
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
<style scoped></style>