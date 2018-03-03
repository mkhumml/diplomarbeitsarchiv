<template>
    <div id="login" class="flz-box">
        <div class="article flz-nospacer">
            <div class="flz-box flz-nospacer border">
                <h1>Anmelden</h1>
                <div class="flz-form" v-if="loggedIn === false && register === false">
                    <label>Email</label>
                    <input type="text" v-model="email">
                    <label>Passwort</label>
                    <input type="text" v-model="password"><br>
                    <div class="flz-box flz-nospacer">
                        <div class="flz-box flz-50 flz-nospacer">
                            <button v-on:click="login">Login</button>
                        </div>
                        <div class="flz-box flz-50 flz-nospacer">
                            <a href="#">Forgot password?</a>
                        </div>
                    </div>
                    <a v-on:click="this.register = true">new Register</a>
                </div>
                <div v-else-if="loggedIn === true && register === false" class="flz-form">
                    <p v-model="lastUsedByMe"></p>
                </div>
                <div class="flz-form" v-if="register === true">
                    <label>Email</label>
                    <input type="email" v-model="newEmail">
                    <label>Passwort</label>
                    <input type="password" v-model="newPassword"><br>
                    <div class="flz-box flz-nospacer">
                        <div class="flz-box flz-50 flz-nospacer">
                            <button v-on:click="registerNew">Register</button>
                            <button v-on:click="this.register = false">Cancel</button>
                        </div>
                    </div>
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
                newPassword2: "",
                loggedIn: false,
                lastUsedByMe: "",
                users: [],
                register: false
            }
        },
        methods: {
            login: function () {
                this.users[0].email = this.email;
                this.users[0].password = this.password;
                axios.post('/diplomarbeitsarchiv/api/login', JSON.stringify(this.users[0]))
                    .then(response => {
                        if (response.data === 1) {
                            console.log("session1")
                        }
                        else {
                            console.log("keinesession")
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            registerNew() {
                this.register = false
                this.users[0].email = this.newEmail;
                this.users[0].password = this.newPassword;
                axios.post('/diplomarbeitsarchiv/api/register', JSON.stringify(this.users[0]))
                    .then(response => {
                        console.log(response)
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                this.register = false;
            }
        },
        beforeCreate: function () {
            axios.get('/diplomarbeitsarchiv/api/users')
                .then(response => {
                    // JSON responses are automatically parsed.
                    this.users = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    }
</script>
<style scoped>
</style>