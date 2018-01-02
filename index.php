<!DOCTYPE html>
<html lang="en">
<?php
    $test = "hallo";
?>
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <script type="text/javascript" src="scripts/vue-2.5.13.js"></script>
    <script type="text/javascript" src="scripts/axios-0.17.1.js"></script>
    <link rel="stylesheet" type="text/css" href="styles/diplomarbeitsarchiv.min.css"
</head>
<body>
<div id="app2">
    <h1>Eingabe</h1>
    <input type="text" v-model="firstName"/>
    <!--<span> {{ firstName }} </span>-->
    <input type="text" v-model="lastName"/>
    <!--<span> {{ lastName }} </span>-->
    <input type="text" v-model="age"/>
    <!--<span> {{ age }} </span>-->
    <button @click="buttonClicked" >Save</button>
</div>
</body>
<script src="/dist/build.js"></script>
</html>
