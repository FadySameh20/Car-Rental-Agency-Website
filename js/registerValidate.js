function validateRegisterForm() {
    var fields = ["fName", "lName", "Email", "Password", "Confirm", "mobile","sex","birthDate", "ssn"];
    var n = fields.length;
    var errors = [];
    var form = document.forms["myForm"];
    for (var i = 0; i < n; i++) {
        var fieldname = fields[i];
        if (form[fieldname].value === "") {
            if (fieldname === "Confirm") {
                fieldname = "Confirm Password";
            }
            if(fieldname=="fName"){
                fieldname="First Name";
            }
            if(fieldname==="lName"){
                fieldname="Last Name";
            }
            if(fieldname==="birthDate"){
                fieldname="Birth Date";
            }
            errors.push(fieldname);
        }
    }

    if (errors.length) {
        alert(errors.join() + " must be filled out");
    }

    if (form["mobile"].value.length !== 11) {
        alert("Mobile phone must be 11 digits\n");
    }
    if (form["ssn"].value.length !== 14) {
        alert("SSN must be 14 digits\n");
    }
    if (form["Password"].value !== form["Confirm"].value) {
        alert("Password and Confirm password aren't the same\n");

    }
    if(errors.length || form["mobile"].value.length !== 11 ||form["ssn"].value.length !== 14 ||form["Password"].value !== form["Confirm"].value){
        return false;
    }
}