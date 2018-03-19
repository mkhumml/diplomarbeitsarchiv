<template>
    <div id="login" class="flz-box flz-form">
        <h1 v-if="! register  && ! forgotPassword">Anmelden</h1>
        <h1 v-if="register && ! forgotPassword ">Registrieren</h1>
        <h1 v-if="forgotPassword">Reset Password</h1>
        <div class="flz-box">
            <label v-if="register || !forgotPassword" for="email">Email</label>
            <input v-if="register || !forgotPassword" id="email" type="text" v-model="email">
            <label v-if="register" for="repeatemail">Wiederholte Email</label>
            <input v-if="register" id="repeatemail" type="text" v-model="repeatemail">
            <label v-if="register || ! forgotPassword" for="password">Passwort</label>
            <input v-if="register || ! forgotPassword" id="password" type="password" v-model="password">
            <label v-show="register" for="repeatpassword">Wiederholtes Passwort</label>
            <input v-show="register" id="repeatpassword" type="password" v-model="repeatpassword">
            <label v-show="forgotPassword" for="resetpassword">Email</label>
            <input v-show="forgotPassword" id="resetpassword" type="password" v-model="resetpassword">
            <br>
            <div v-show="forgotPassword" class="flz-box flz-50 flz-nospacer">
                <button @click="onResetPassword">Email senden</button>
            </div>
            <div v-if="forgotPassword" class="flz-box flz-50 flz-nospacer">
                <button @click="forgotPassword = false">Abbrechen</button>
            </div>
            <div v-if="! register && ! forgotPassword" class="flz-box flz-50 flz-nospacer">
                <button @click="onLogin">Einloggen</button>
            </div>
            <div v-if="! register && ! forgotPassword" class="flz-box flz-50 flz-nospacer paddingtop">
                <a @click="forgotPassword = true">Passwort vergessen?</a>
            </div>
            <div v-if="! register && ! forgotPassword" class="flz-box flz-nospacer paddingtop">
                <a @click="register = true">Registrieren</a>
            </div>
            <div v-if="register" class="flz-box flz-45 flz-nospacer">
                <button @click="onRegister">Registrieren</button>
            </div>
            <div v-if="register" class="flz-box flz-55 flz-nospacer">
                <button @click="register = false">Abbrechen</button>
        </div>
        <div class="flz-box" v-else-if="loggedIn && ! register && ! forgotPassword">
            <p v-model="lastUsedByMe"></p>
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
                            this.loggedIn = true;
                        }
                        else {
                            console.log("keinesession")
                            this.loggedIn = false;
                            this.email = "";
                            this.password = "";
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
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
                axios.post('/diplomarbeitsarchiv/api/resetpassword', this.resetpassword)
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