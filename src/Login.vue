<template>
    <div id="login" class="flz-box flz-form">
        <h1 v-if="! register  && ! forgotPassword">Anmelden</h1>
        <h1 v-if="register && ! forgotPassword ">Registrieren</h1>
        <h1 v-if="forgotPassword">Reset Password</h1>
        <div class="flz-box" v-if="! loggedIn && ! register && ! forgotPassword">
            <label for="email">Email</label>
            <input id="email" type="text" v-model="email">
            <label for="password">Passwort</label>
            <input id="password" type="password" v-model="password"><br>
            <div class="flz-box flz-50 flz-nospacer">
                <button v-on:click="onLogin">Login</button>
            </div>
            <div class="flz-box flz-50 flz-nospacer">
                <a @click="forgotPassword = true">Forgot password?</a>
            </div>
            <div class="flz-box flz-nospacer">
                <a @click="register = true">Register</a>
            </div>
        </div>
        <div class="flz-box" v-if="forgotPassword && ! loggedIn && ! register">
            <label for="resetpassword">Email</label>
            <input id="resetpassword" type="password" v-model="resetpassword">
            <button @click="onResetPassword">Reset password</button>
        </div>
        <div class="flz-box" v-else-if="loggedIn && ! register && ! forgotPassword">
            <p v-model="lastUsedByMe"></p>
        </div>
        <div class="flz-box" v-if="register">
            <label for="email" >Email</label>
            <input id="email" type="text" v-model="email">
            <label for="repeatemail">Repeat Email</label>
            <input id="repeatemail" type="text" v-model="repeatemail">
            <label for="password">Passwort</label>
            <input id="password" type="password" v-model="password">
            <label for="repeatpassword">Repeat Passwort</label>
            <input id="repeatpassword" type="text" v-model="repeatpassword">
            <div class="flz-box flz-nospacer">
                <button @click="onRegister">Register</button>
                <button @click="register = false">Cancel</button>
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
                repeatemail: "",
                repeatpassword: "",
                loggedIn: false,
                lastUsedByMe: "",
                register: false,
                forgotPassword: false,
                resetpassword: ""
            }
        },
        methods: {
            onLogin() {
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
            },
            onRegister() {
                if (this.email === this.repeatemail && this.password === this.repeatpassword) {
                    let user = {id: null, email: this.email, password: this.password};
                    console.log(user);
                    axios.post('/diplomarbeitsarchiv/api/register', user)
                        .then(response => {
                            console.log(response)
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                    this.register = false;
                    this.loggedIn = true;
                }
                else {
                    console.log("Email or Password is differently repeated")
                    this.register = false;
                    this.loggedIn = false;
                }
            },
            onResetPassword() {
                axios.post('/diplomarbeitsarchiv/api/diplomarbeiten', this.resetpassword)
                    .then(response => {
                        console.log(response)
                    })
                    .catch(error => {
                        console.log(error)
                    });
                this.forgotPassword = false;
            }
        }
    }
</script>
<style scoped>
</style>