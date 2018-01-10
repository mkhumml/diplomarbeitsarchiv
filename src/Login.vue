<template>
    <div id="login" class="flz-box">
        <div class="article flz-nospacer">
            <div class="flz-box flz-nospacer border">
                <h1>Anmelden</h1>
                <div class="flz-form">
                    <p></p>
                    <input type="text" name="Email" value="Email">
                    <p></p>
                    <input type="password" name="Password" value="Password"><br>
                    <div class="flz-box flz-nospacer">
                        <div class="flz-box flz-50 flz-nospacer">
                            <input type="submit" value="Login">
                        </div>
                        <div class="flz-box flz-50 flz-nospacer">
                            <a href="#">Forgot password?</a>
                        </div>
                    </div>
                    <p><a href="#">new Register</a></p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "login"
    }
</script>

<style scoped>

</style>