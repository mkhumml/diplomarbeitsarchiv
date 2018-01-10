/*
components
refs

*/
new Vue({
    el: '#application',
    data: {
        result: "",
        firstName: "Harald",
        lastName: "Humml",
        age: "48"
    },
    methods: {

        buttonClicked: function () {
            axios.post('service.php', {
                    firstName: this.firstName,
                    lastName: this.lastName,
                    age: this.age
                })
                .then(function (response) {
                    console.log(response);
                })
                .catch(function (error) {
                    // Wu oh! Something went wrong
                    console.log(error.message);
                });
        },
    },
    computed: {},
    created: function () {
/*        axios.get('http://localhost:63342/diplomarbeitsarchiv/service.php?_ijt=mp428p2lt9tjfcovu9sqbem9oq')
            .then(function (response) {
                console.log(response.data);
            })
            .catch(function (error) {
                console.error(error);
            });*/
    }

});