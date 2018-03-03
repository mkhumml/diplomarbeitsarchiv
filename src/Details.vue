<template>
    <div class="flz-box details">
        <div class="flz-box flz-66 flz-nospacer">
            <div class="flz-box">
                <h1>Title</h1>
                <input v-model="diploma.title" :readonly="readonly">
            </div>
            <div class="flz-box flz-50">
                <h1>Authors</h1>
                <multiselect v-model="diploma.authors" :options="optionsAuthors" :disabled="readonly"
                             :multiple="true" :close-on-select="false" :hide-selected="true"
                             :track-by="id" :custom-label="showAuthor" :clear-on-select="false"
                             selectLabel=""></multiselect>
            </div>
            <div class="flz-box flz-50">
                <h1>Tutors</h1>
                <multiselect v-model="diploma.tutors" :options="optionsTutors" :disabled="readonly"
                             :multiple="true" :close-on-select="false" :hide-selected="true"
                             :track-by="id" :custom-label="showTutor" :clear-on-select="false"></multiselect>
            </div>
        </div>
        <div class="flz-box flz-33">
            <img src="images/Download.jpeg">
        </div>
        <div class="flz-box flz-50">
            <h1>Department</h1>
            <multiselect v-model="diploma.departments" :options="optionsDepartments" :disabled="readonly"
                         :multiple="true" :close-on-select="false" :hide-selected="true"
                         :track-by="id" :custom-label="showDepartment"
                         :clear-on-select="false"></multiselect>
        </div>
        <div class="flz-box flz-50 flz-nospacer">
            <div class="flz-box flz-33">
                <h1>Year</h1>
                <input v-model="diploma.year" :readonly="readonly">
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
                <app-upload v-bind:readonly="readonly"></app-upload>
                <input v-model="diploma.upload" :readonly="readonly">
            </div>
        </div>
        <div class="flz-box flz-33">
            <h1>Summary</h1>
            <input v-model="diploma.summary" :readonly="readonly">
        </div>
        <div class="flz-box flz-33">
            <h1>Notes</h1>
            <input v-model="diploma.notes" :readonly="readonly">
        </div>
        <div class="flz-box flz-33">
            <h1>Attachments</h1>
            <input v-model="diploma.attachments" :readonly="readonly">
        </div>
        <div class="flz-box">
            <h1>Tags</h1>
            <multiselect v-model="diploma.tags" :options="optionsTags" :disabled="readonly"
                         :taggable="true" :multiple="true" :close-on-select="false" :hide-selected="true"
                         :custom-label="showTags" :clear-on-select="false"></multiselect>
        </div>
        <div class="flz-box">
            <button v-show="readonly" v-on:click="onEdit">Edit</button>
            <button v-show="readonly" v-on:click="onDelete">Delete</button>
            <button v-show="! readonly" v-on:click="onSave">Save</button>
            <button v-show="! readonly" v-on:click="onReset">Cancel</button>
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
                    attachments: this.diploma.attachments,
                    tags: this.diploma.tags
                },
                optionsAuthors: [],
                optionsDepartments: [],
                optionsTags: [],
                optionsTutors: [],
                readonly: true,
            }
        },
        methods: {
            onReset() {
                this.setReadonly(true);
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
            },
            showAuthor(author) {
                return `${author.firstname} ${author.lastname}`;
            },
            showTutor(tutor) {
                return `${tutor.firstname} ${tutor.lastname}`;
            },
            showDepartment(department) {
                return department.name;
            },
            showTags(tag) {
                return tag.name;
            },
            onEdit() {
                this.setReadonly(false);
            },
            setReadonly(readonly) {
                this.readonly = readonly;
            },
            onSave() {
                axios.post('/diplomarbeitsarchiv/api/diplomarbeiten/', this.diploma)
                    .then(response => {
                        console.log(response.data);
                        this.diploma.title = response.data.title;
                        this.diploma.authors = response.data.authors;
                        this.diploma.tutors = response.data.tutors;
                        this.diploma.departments = response.data.departments;
                        this.diploma.year = response.data.year;
                        this.diploma.upload = response.data.upload;
                        this.diploma.summary = response.data.summary;
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
                        this.$emit('deleteDiploma', response.data)
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
        }
    }

</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped></style>