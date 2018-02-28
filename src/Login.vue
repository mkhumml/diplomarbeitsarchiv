<template>
    <div id="login" class="flz-box">
        <div class="article flz-nospacer">
            <div class="flz-box flz-nospacer border">
                <h1>Anmelden</h1>
                <div class="flz-form" v-if="loggedIn === false">
                    <p></p>
                    <input type="text" v-model="email">
                    <p></p>
                    <input type="password" v-model="password"><br>
                    <div class="flz-box flz-nospacer">
                        <div class="flz-box flz-50 flz-nospacer">
                            <button v-on:click="login">Login</button>
                        </div>
                        <div class="flz-box flz-50 flz-nospacer">
                            <a href="#">Forgot password?</a>
                        </div>
                    </div>
                    <p>new Register</p>
                </div>
                <div v-else-if="loggedIn" class="flz-form">
                    <p v-model="lastUsedByMe"></p>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                email: "",
                password: "",
                newEmail: "",
                newPassword: "",
                loggedIn: false,
                lastUsedByMe: "",
                user: [
                    {}
                ]
            }
        },
        methods: {
            login: function () {
                axios.post('/diplomarbeitsarchiv/api/diplomarbeiten/', {
                    email: this.email,
                    password: this.password
                })
                    .then(response => {
                        console.log(response)
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                this.loggedIn = !this.loggedIn
            }
        }
    }
</script>
<style scoped>
</style>