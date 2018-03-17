<template>
    <div class="container">
        <div class="large-12 medium-12 small-12 cell">
            <input type="file" id="files" ref="attachments" multiple v-on:change="onAttachmentSelected" :disabled="readonly"/>
            <input type="file" id="file"  ref="diploma" v-on:change="onDiplomaSelected" :disabled="readonly"/>
            <button v-on:click="submitFiles()" :disabled="readonly">Submit</button>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'app',
        props : {
            readonly : {
                type: Boolean,
                required: true
            }
        },
        data() {
            return {
                attachments: [],
                diplomaFile: ""
            }
        },
        methods: {
            onDiplomaSelected: function () {
                this.diplomaFile = this.$refs.diploma.files[0];
            },
            onAttachmentSelected: function () {
                this.attachments = this.$refs.attachments.files;
            },
            submitFiles() {
                let formData = new FormData();
                if(this.diplomaFile.length > 0) {
                    formData.append("diplomaFile", this.diplomaFile);
                }
                if(this.attachments.length > 0) {
                    for (let i = 0; i < this.attachments.length; i++) {
                        formData.append('attachments[' + i + ']', this.attachments[i]);
                    }
                }


/*                formData.append("diplomaFile", this.diplomaFile);
                for (var i = 0; i < this.attachments.length; i++) {
                    let file = this.attachments[i];
                    formData.append('attachments[' + i + ']', file);
                }*/
                axios.post('/diplomarbeitsarchiv/api/uploads', formData, {headers: {'Content-Type': 'multipart/form-data'}})
                    .then(function () {
                        console.log('SUCCESS!!');
                    })
                    .catch(function () {
                        console.log('FAILURE!!');
                    });
            }
        }
    }

</script>

<!-- SASS styling -->
<style lang="scss">
</style>