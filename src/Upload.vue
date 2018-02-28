<template>
    <div class="container">
        <div class="large-12 medium-12 small-12 cell">
            <input type="file" id="files" ref="files" multiple v-on:change="handleFileUpload()"/>
            <button v-on:click="submitFiles()">Submit</button>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'app',
        data() {
            return {
                files: ''
            }
        },
        methods: {
            handleFileUpload: function () {
                this.files = this.$refs.files.files;
            },
            submitFiles() {
                let formData = new FormData();
                for (var i = 0; i < this.files.length; i++) {
                    let file = this.files[i];
                    formData.append('files[' + i + ']', file);
                }
                axios.post('/diplomarbeitsarchiv/uploads', formData, {headers: {'Content-Type': 'multipart/form-data'}})
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