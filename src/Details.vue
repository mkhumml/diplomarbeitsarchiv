<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style src="../styles/vue-multiselect-override.min.css"></style>
<template>
    <div class="flz-box flz-form flz-nospacer details">
        <div class="flz-box flz-nospacer">
            <div class="flz-box flz-70 flz-100-lte-xs">
                <label for="title">Titel</label>
                <input id="title" type="text" v-model="diploma.title" :readonly="readonly">
            </div>
            <div class="flz-box flz-30 flz-100-lte-xs">
                <label for="year">Jahr</label>
                <input id="year" type="text" v-model="diploma.year" :readonly="readonly">
            </div>
        </div>
        <div class="flz-box">
            <label for="authors">Verfasser</label>
            <multiselect
                    id="authors"
                    placeholder="Vorname / Nachname"
                    track-by="id"
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
        </div>
        <div class="flz-box flz-nospacer">
            <div class="flz-box flz-50 flz-100-lte-xs">
                <label for="tutors">Betreuer</label>
                <multiselect
                        id="tutors"
                        placeholder="Vorname / Nachname"
                        selectLabel=""
                        tagPlaceholder="Vorname / Nachname"
                        track-by="id"
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
            </div>
            <div class="flz-box flz-50 flz-100-lte-xs">
                <label for="department">Abteilung</label>
                <multiselect id="department"
                             label="name"
                             selectLabel=""
                             placeholder="Abteilung"
                             tagPlaceholder="Abteilung"
                             track-by="id"
                             v-model="diploma.departments"
                             :close-on-select="true"
                             :disabled="readonly"
                             :hide-selected="true"
                             :multiple="true"
                             :options="optionsDepartments"
                             :taggable="true"
                             @tag="addDepartment">
                </multiselect>
            </div>
        </div>
        <!--Upload im Responsive Design hat keine Buttons-->
        <div class="flz-box flz-nospacer">
            <div class="flz-box flz-50 flz-100-lte-xs">
                <label for="diplomarbeit">Diplomarbeit</label>
                <div v-if="diploma.upload.tmp_name !== null" class="flz-box attachments flz-nospacer">
                    <a v-bind:href="diploma.upload.tmp_name" target="_blank">{{diploma.upload.name}}</a>
                </div>
                <input id="diplomarbeit" type="file" id="file" value="" ref="diploma" v-on:change="onDiplomaSelected"
                       :disabled="readonly" v-show="!readonly"/>
            </div>
            <div class="flz-box flz-50 flz-100-lte-xs">
                <label>Anhänge</label>
                <ul class="attachments flz-nospacer">
                    <li v-for="attachment in diploma.attachments">
                        <a v-bind:href="attachment.tmp_name" target="_blank">{{attachment.name}}</a>
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
                         track-by="id"
                         v-model="diploma.tags"
                         :close-on-select="true"
                         :disabled="readonly"
                         :hide-selected="true"
                         :multiple="true"
                         :options="optionsTags"
                         :taggable="true"
                         @tag="addTag">
            </multiselect>
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
    //TODO: reset password withTask of undefined
    //TODO: register withTask of undefined
    //TODO: Dropdown styling & pflichtfelder & maximalanzeige & sortieren
    //TODO: upload
    //TODO: responsive Design & Design

    export default {
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
                readonly: true,
                attachments: [],
                diplomaFile: ""
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
                else if (parts.length > 2) {
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
                else if (parts.length > 2) {
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
                let formData = new FormData();
                if (this.diplomaFile !== null) {
                    formData.append("diplomaFile", this.diplomaFile);
                }
                if (this.attachments.length > 0) {
                    for (let i = 0; i < this.attachments.length; i++) {
                        formData.append('attachments[' + i + ']', this.attachments[i]);
                    }
                }
                formData.append("diploma", JSON.stringify(this.diploma));
                axios.post('/diplomarbeitsarchiv/api/diplomarbeiten/', formData, {headers: {'Content-Type': 'multipart/form-data'}})
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
                        this.$refs.diploma.value = null;
                        this.$refs.attachments.value = null;
                        this.setReadonly(true);
                    })
                    .catch(function (error) {
                        // FIXME Show all AJAX errors in UI and not in browser console
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
            onDiplomaSelected: function () {
                this.diplomaFile = this.$refs.diploma.files[0];
            },
            onAttachmentSelected: function () {
                this.attachments = this.$refs.attachments.files;
            }
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
<style scoped></style>