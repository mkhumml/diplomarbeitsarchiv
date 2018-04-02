<template>
    <!--
    register is the boolean attribute used to toggle the registration formular
    forgotPassword is the boolean attribute used to toggle the reset password formular
    loggedIn is the property used to toggle the login formular

    v-if decides whether the content is rendered or not
    v-model binds the variable to the input field

    div containers are used because they work better with the css framework
    -->
    <div id="login" class="flz-box flz-form">
        <h1 v-if="! register  && ! forgotPassword">Anmelden</h1>
        <h1 v-if="register && ! forgotPassword ">Registrieren</h1>
        <h1 v-if="forgotPassword">Reset Password</h1>
        <p class="required" v-if="this.errorMessage.length > 0">
            {{errorMessage}}</p>
        <p v-if="successLogin.length > 0">{{successLogin}}</p>
        <div class="flz-box" v-if="loggedIn && ! register && ! forgotPassword">
            <button @click="onLogout">Ausloggen</button>
        </div>
        <div class="flz-box">
            <div v-show="!loggedIn" class="flz-box flz-nospacer">
                <label v-if="register || !forgotPassword" for="email">Email</label>
                <input v-if="register || !forgotPassword" id="email" type="email" v-model="email">
                <label v-if="register" for="repeatemail">Wiederholte Email</label>
                <input v-if="register" id="repeatemail" type="email" v-model="repeatemail">
                <label v-if="register || ! forgotPassword" for="password">Passwort</label>
                <input v-if="register || ! forgotPassword" id="password" type="password" v-model="password">
                <label v-if="register" for="repeatpassword">Wiederholtes Passwort</label>
                <input v-if="register" id="repeatpassword" type="password" v-model="repeatpassword">
                <label v-if="forgotPassword" for="resetpassword">Email</label>
                <input v-if="forgotPassword" id="resetpassword" type="email" v-model="resetpassword">
                <br>
                <div v-if="forgotPassword" class="flz-box flz-50 flz-nospacer">
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
        //data function contains variables
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
                errorMessage: "",
                catchError: "Da ist ein grober Fehler unterlaufen!"
            }
        },
        methods: {
            onLogin() {
                // execute HTTP post method when login formular is submitted
                // email and password are sent to the API as a JSON object
                let user = {id: null, email: this.email, password: this.password};
                axios.post('/diplomarbeitsarchiv/api/login', user)
                    .then(response => {
                        //handling login response and reset bindings
                        if (response.data === 1) {
                            this.successLogin = "Sie haben sich erfolgreich eingeloggt!"
                            this.errorMessage = "";
                            this.loggedIn = true;
                            this.$emit('onSuccessLogin', this.loggedIn);
                            this.email = "";
                            this.password = "";
                        }
                        //error message
                        else {
                            this.errorMessage = "Dieser Benutzer existiert nicht!";
                            this.loggedIn = false;
                            this.password = "";
                        }
                    })
                    //catching error 404/500/etc
                    .catch(function (error) {
                        alert(this.catchError)
                        console.log(error)
                    });
            },
            onLogout() {
                // execute HTTP post sending object with email=logout
                // API seperates logout from login with if-clause
                let user = {id: null, email: "logout", password: null};
                axios.post('/diplomarbeitsarchiv/api/login', user)
                    .then(response => {
                        //handling logout response
                        if (response.data === 0) {
                            this.successLogin = "";
                            this.loggedIn = false;
                            this.$emit('onSuccessLogin', this.loggedIn)
                        }
                        //error message
                        else {
                            alert("Bitte versuchen Sie es erneut!")
                        }
                    })
                    //catching error 404/500/etc
                    .catch(error => {
                        alert(this.catchError)
                        console.log(error)
                    })
            },
            onRegister() {
                //validate input fields
                if (this.email === this.repeatemail && this.password === this.repeatpassword && this.email !== "" && this.password !== "" && this.checkEmail(this.email)) {
                    //execute HTTP post sending register object
                    let user = {id: null, email: this.email, password: this.password};
                    axios.post('/diplomarbeitsarchiv/api/register', user)
                        .then(response => {
                            //handling response and reset bindings
                            this.successLogin = "Sie haben sich erfolgreich eingeloggt!"
                            this.errorMessage = "";
                            this.loggedIn = true;
                            this.$emit('onSuccessLogin', this.loggedIn);
                            this.email = "";
                            this.password = "";
                        })
                        //catching error 404/500/etc
                        .catch(function (error) {
                            alert(this.catchError)
                            console.log(error)
                        });
                    this.register = false;
                    this.loggedIn = true;
                    this.errorMessage = "";
                    this.repeatemail = "";
                    this.repeatpassword = "";
                }
                //error message
                else {
                    this.errorMessage = "Bitte überprüfen Sie nochmal Ihre Eingabe!";
                }
            },
            // unicode for email validation
            checkEmail(email) {
                var check = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return check.test(email);
            },
            //display Register Form
            onRegisterForm() {
                this.register = true;
                this.email = "";
                this.password = "";
                this.errorMessage = "";
            },
            //reset register form
            onCancelRegister() {
                this.register = false;
                this.email = "";
                this.password = "";
                this.repeatemail = "";
                this.repeatpassword = "";
                this.errorMessage = "";
            },
            //posting HTTP request with the needed email to API
            onResetPassword() {
                let object = {id: null, email: this.resetpassword}
                axios.post('/diplomarbeitsarchiv/api/resetpassword', object)
                    .then(response => {
                        //API has to send email, only possible on WebServer
                        this.errorMessage = "Eine Email wurde gesendet!"
                        console.log(response)
                    })
                    .catch(error => {
                        alert(this.catchError)
                        console.log(error)
                    });
                //reset form to login form
                this.forgotPassword = false;
            },
            //changing form to reset password form
            onResetPasswordForm() {
                this.forgotPassword = true;
                this.errorMessage = "";
            },
            //changing form from reset password form to login form
            onCancelResetPassword() {
                this.resetpassword = "";
                this.forgotPassword = false;
                this.email = "";
                this.password = "";
            },
            //get cookie name, not used due to "remember me" is in progress
            getCookie(name) {
                var cookieName = name + "=";
                var cookieArray = document.cookie.split(';');
                for (var i = 0; i < cookieArray.length; i++) {
                    var cookie = cookieArray[i];
                    while (cookie.charAt(0) == ' ') {
                        cookie = cookie.substring(1);
                    }
                    if (cookie.indexOf(cookieName) == 0) {
                        return cookie.substring(cookieName.length, cookie.length);
                    }
                }
                return "";
            }
        }
    }
</script>
<style scoped>
</style>