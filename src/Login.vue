<template>
    <div id="login" class="flz-box">
        <div class="article flz-nospacer">
            <div class="flz-box flz-nospacer border">
                <h1 v-if="register === false && forgotPassword === false">Anmelden</h1>
                <h1 v-if="register === true && forgotPassword === false">Registrieren</h1>
                <h1 v-if="forgotPassword === true">Reset Password</h1>
                <div class="flz-form" v-if="loggedIn === false && this.register === false && forgotPassword === false">
                    <label>Email</label>
                    <input type="text" v-model="email">
                    <label>Passwort</label>
                    <input type="text" v-model="password"><br>
                    <div class="flz-box flz-nospacer">
                        <div class="flz-box flz-50 flz-nospacer">
                            <button v-on:click="login">Login</button>
                        </div>
                        <div class="flz-box flz-50 flz-nospacer">
                            <a @click="forgotPassword = !forgotPassword">Forgot password?</a>
                        </div>
                    </div>
                    <div class="flz-box">
                        <a href="#" v-on:click="register = true">new Register</a>
                    </div>
                </div>
                <div class="flz-form" v-if="forgotPassword === true">
                    <h1>Email</h1>
                    <input type="text" v-model="resetpassword">
                    <button @click="onResetPassword"></button>
                </div>
                <div v-else-if="loggedIn === true && this.register === false" class="flz-form">
                    <p v-model="lastUsedByMe"></p>
                </div>
                <div class="flz-form" v-if="register === true">
                    <label>Email</label>
                    <input type="text" v-model="newEmail">
                    <label>Repeat Email</label>
                    <input type="text" v-model="repeatNewEmail">
                    <label>Passwort</label>
                    <input type="text" v-model="newPassword"><br>
                    <label>Repeat Passwort</label>
                    <input type="text" v-model="repeatNewPassword"><br>
                    <div class="flz-box flz-nospacer">
                        <div class="flz-box flz-50 flz-nospacer">
                            <button v-on:click="registerNew">Register</button>
                            <button v-on:click="register = false">Cancel</button>
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
                repeatNewEmail: "",
                newPassword: "",
                repeatNewPassword: "",
                loggedIn: false,
                lastUsedByMe: "",
                register: false,
                forgotPassword: false,
                resetpassword: ""
            }
        },
        methods: {
            login: function () {
                let user = {id: null, email: this.email, password: this.password};
                // TODO repeated PW, repeated Mailadress
                axios.post('/diplomarbeitsarchiv/api/login', user)
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
                this.loggedIn = true;
            }
        },
        registerNew() {
            if (this.newEmail === this.repeatNewEmail && this.newPassword === this.repeatNewPassword) {
                let user = {id: null, email: this.newEmail, password: this.newPassword};
                console.log(user);
                axios.post('/diplomarbeitsarchiv/api/register', user)
                    .then(response => {
                        console.log(response)
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
            else {
                console.log("Email or Password is differently repeated")
                this.register = false;
                this.loggedIn = true;
            }
        },
        onResetPassword() {
            axios.post('/diplomarbeitsarchiv/api/diplomarbeiten', this.resetpassword)
                .then(response => {
                    console.log(response)
                })
                .catch(error => {
                    console.log(error)
                })
        }
    }
</script>

<style scoped>
</style>