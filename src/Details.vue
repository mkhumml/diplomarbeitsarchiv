<template>
    <div class="flz-box details">
        <div class="flz-box flz-66 flz-nospacer">
            <div class="flz-box">
                <h1>Title</h1>
                <input type="text">
            </div>
            <div class="flz-box flz-50">
                <h1>Authors</h1>
                <input type="text">
            </div>
            <div class="flz-box flz-50">
                <h1>Tutors</h1>
                <input type="text">
            </div>
        </div>
        <div class="flz-box flz-33">
            <img src="Images/Download.jpeg">
        </div>
        <div class="flz-box flz-50">
            <h1>Department</h1>
            <input type="text">
        </div>
        <div class="flz-box flz-50 flz-nospacer">
            <div class="flz-box flz-33">
                <h1>Year</h1>
                <input type="text">
            </div>
            <div class="flz-box flz-66">
                <h1>Diplomathesi</h1>
                <input type="text">
            </div>
        </div>
        <div class="flz-box flz-33">
            <h1>Summary</h1>
            <input type="text" >
        </div>
        <div class="flz-box flz-33">
            <h1>Notes</h1>
            <input type="text">
        </div>
        <div class="flz-box flz-33">
            <h1>Attachments</h1>
            <input type="text">
        </div>
        <div class="flz-box">
            <h1>Tags</h1>
            <input type="text">
        </div>
        <div class="flz-box">
            <button>Edit</button>
            <button>Delete</button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['diplomathesis'],
        data() {
            return {
                diplomathesis: [
                    {title: "diplomarbeitstitel"},
                    {author: "diplomarbeitsauthor"},
                    {tutor: "diplomarbeitstutor"},
                    {department: "fachabteilung"},
                    {year: "jahr"},
                    {upload: "diplomatheiss.pdf"},
                    {summary: "loremipsum"},
                    {notes: "notes"},
                    {attachments: "attachments"},
                    {tags: "tags"}
                ]
            }
        }
    }

</script>

<style scoped>

</style>