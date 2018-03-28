<template>
    <div id="login" class="flz-box flz-form">
        <h1 v-if="! register  && ! forgotPassword">Anmelden</h1>
        <h1 v-if="register && ! forgotPassword ">Registrieren</h1>
        <h1 v-if="forgotPassword">Reset Password</h1>
        <p v-if="this.errorMessage.length > 0 ||this.successLogin.length > 0">{{errorMessage}}{{successLogin}}</p>
        <div class="flz-box" v-if="loggedIn && ! register && ! forgotPassword">
            <button @click="onLogout">Ausloggen</button>
        </div>
        <div class="flz-box">
            <div v-show="!loggedIn" class="flz-box flz-nospacer">
                <label v-if="register || !forgotPassword"
                       for="email">Email</label>
                <input v-if="register || !forgotPassword"
                       id="email" type="text" v-model="email">
                <label v-if="register" for="repeatemail">Wiederholte Email</label>
                <input v-if="register" id="repeatemail" type="text" v-model="repeatemail">
                <label v-if="register || ! forgotPassword"
                       for="password">Passwort</label>
                <input v-if="register || ! forgotPassword"
                       id="password" type="password" v-model="password">
                <label v-show="register" for="repeatpassword">Wiederholtes
                       Passwort</label>
                <input v-show="register" id="repeatpassword" type="password"
                       v-model="repeatpassword">
                <label v-show="forgotPassword" for="resetpassword">Email</label>
                <input v-show="forgotPassword" id="resetpassword" type="password"
                       v-model="resetpassword">
                <br>
                <div v-show="forgotPassword" class="flz-box flz-50 flz-nospacer">
                    <button @click="onResetPassword">Email senden</button>
                </div>
                <div v-if="forgotPassword" class="flz-box flz-50 flz-nospacer">
                    <button @click="onCancelResetPassword">Abbrechen</button>
                </div>
                <div v-if="! register && ! forgotPassword" class="flz-box flz-50
                     flz-nospacer">
                    <button @click="onLogin">Einloggen</button>
                </div>
                <div v-if="! register && ! forgotPassword" class="flz-box flz-50
                     flz-nospacer paddingtop">
                    <a @click="onResetPasswordForm">Passwort vergessen?</a>
                </div>
                <div v-if="! register && ! forgotPassword" class="flz-box
                     flz-nospacer paddingtop">
                    <a @click="onRegisterForm">Registrieren</a>
                </div>
                <div v-if="register" class="flz-box flz-45 flz-nospacer">
                    <button @click="onRegister">Registrieren</button>
                </div>
                <div v-if="register" class="flz-box flz-55 flz-nospacer">
                    <button @click="onCancelRegister">Abbrechen</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            loggedIn: {
                type: Boolean,
                required: true
            }
        },
        data() {
            return {
                email: "",
                password: "",
                repeatemail: "",
                repeatpassword: "",
                successLogin: "",
                register: false,
                forgotPassword: false,
                resetpassword: "",
                errorMessage: ""
            }
        },
        methods: {
            onLogin() {
                let user = {id: null, email: this.email, password: this.password};
                // TODO repeated PW, repeated Mailadress
                axios.post('/diplomarbeitsarchiv/api/login', user)
                    .then(response => {
                        if (response.data === 1) {
                            this.successLogin = "Sie haben sich erfolgreich eingeloggt!"
                            this.errorMessage = "";
                            this.loggedIn = true;
                            this.$emit('onSuccessLogin', this.loggedIn);
                            this.email = "";
                            this.password = "";
                        }
                        else {
                            console.log("keinesession")
                            this.errorMessage = "Dieser User existiert nicht!";
                            this.loggedIn = false;
                            this.email = "";
                            this.password = "";
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            onLogout() {
                let user = {id: null, email: "logout", password: null};
                axios.post('/diplomarbeitsarchiv/api/login', user)
                    .then(response => {
                        if (response.data === 0) {
                            console.log("ausgeloggt")
                            this.successLogin = "";
                            this.loggedIn = false;
                            this.$emit('onSuccessLogin', this.loggedIn)
                        }
                        else {
                            console.log("something was wrong")
                        }
                    })
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
            onRegisterForm() {
              this.register = true;
              this.email = "";
              this.password = "";
            },
            onCancelRegister() {
                this.register = false;
                this.email = "";
                this.password = "";
                this.repeatemail = "";
                this.repeatpassword = "";
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
            },
            onResetPasswordForm() {
                this.forgotPassword = true;
            },
            onCancelResetPassword() {
                this.resetpassword = "";
                this.forgotPassword = false;
                this.email = "";
                this.password = "";
            }
        }
    }
</script>
<style scoped>
</style>