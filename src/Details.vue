<template>
    <div class="flz-box details">
        <div class="flz-box flz-66 flz-nospacer">
            <div class="flz-box">
                <h1>Title</h1>
                <input v-model="diploma.title" readonly v-show="!editonly" class="readonly">
                <input v-model="newTitle" v-show="editonly">
            </div>
            <div class="flz-box flz-50">
                <h1>Authors</h1>
                <input v-model="diploma.author" readonly v-show="!editonly" class="readonly">
                <input v-model="newAuthor" v-show="editonly">
            </div>
            <div class="flz-box flz-50">
                <h1>Tutors</h1>
                <input v-model="diploma.tutor" readonly v-show="!editonly" class="readonly">
                <input v-model="newTutor" v-show="editonly">
            </div>
        </div>
        <div class="flz-box flz-33">
            <img src="images/Download.jpeg">
        </div>
        <div class="flz-box flz-50">
            <h1>Department</h1>
            <input v-model="diploma.department" readonly v-show="!editonly" class="readonly">
            <input v-model="newDepartment" v-show="editonly">
        </div>
        <div class="flz-box flz-50 flz-nospacer">
            <div class="flz-box flz-33">
                <h1>Year</h1>
                <input v-model="diploma.year" readonly v-show="!editonly" class="readonly">
                <input v-model="newYear" v-show="editonly">
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
                <input v-model="diploma.upload" readonly v-show="!editonly" class="readonly">
                <input v-model="newUpload" v-show="editonly">
            </div>
        </div>
        <div class="flz-box flz-33">
            <h1>Summary</h1>
            <input v-model="diploma.summary" readonly v-show="!editonly" class="readonly">
            <input v-model="newSummary" v-show="editonly">
        </div>
        <div class="flz-box flz-33">
            <h1>Notes</h1>
            <input v-model="diploma.notes" readonly v-show="!editonly" class="readonly">
            <input v-model="newNotes" v-show="editonly">
        </div>
        <div class="flz-box flz-33">
            <h1>Attachments</h1>
            <input v-model="diploma.attachments" readonly v-show="!editonly" class="readonly">
            <input v-model="newAttachments" v-show="editonly">
        </div>
        <div class="flz-box">
            <h1>Tags</h1>
            <input v-model="diploma.tags" readonly v-show="!editonly" class="readonly">
            <input v-model="newTags" v-show="editonly">
        </div>
        <div class="flz-box">
            <button v-show="!editonly" v-on:click="changeEdit">Edit</button>
            <button v-show="!editonly" v-on:click="deleteDiploma">Delete</button>
            <button v-show="editonly" v-on:click="changeEdit" v-on:click="save">Save</button>
            <button v-show="editonly" v-on:click="changeEdit">Cancel</button>
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
                title: "sdfg",
                editonly: false,
                filePdfUrl: "",
                newTitle: this.diploma.title,
                newAuthor: this.diploma.author,
                newTutor: this.diploma.tutor,
                newDepartment: this.diploma.department,
                newYear: this.diploma.year,
                newUpload: this.diploma.upload,
                newSummary: this.diploma.summary,
                newNotes: this.diploma.notes,
                newAttachments: this.diploma.attachments,
                newTags: this.diploma.tags,
                options: {
                    url: ''
                },
                files: []
            }
        },
        methods: {
            changeEdit: function () {
                this.editonly = !this.editonly
            },
            save: function () {
                this.diploma.title = this.newTitle;
                this.diploma.author = this.newAuthor;
                this.diploma.tutor = this.newTutor;
                this.diploma.department = this.newDepartment;
                this.diploma.year = this.newYear;
                this.diploma.upload = this.newUpload;
                this.diploma.summary = this.newSummary;
                this.diploma.notes = this.newNotes;
                this.diploma.attachments = this.newAttachments;
                this.diploma.tags = this.newTags;
                axios.post('/diplomarbeitsarchiv/api/diplomarbeiten/', this.diploma)
                    .then(response => {
                        console.log(response.data);
                        // TODO: Update diploma with response.data
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            deleteDiploma: function () {
                axios.delete('/diplomarbeitsarchiv/api/diplomarbeiten/' + this.diploma.id)
                    .then(response => {
                        console.log("Deleted item: " + response.data);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });

                // this.$emit('deleteDiploma', this.diploma.id)
            }
        }
    }

</script>

<style scoped>

</style>