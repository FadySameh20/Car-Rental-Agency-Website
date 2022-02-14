function validateReservationForm() {
    var form = document.forms["myForm"];
    
    if(form["pickup_time"].value > form["return_time"].value){
        alert("Pickup Time must be less than the Return Time");
        return false;
    }

    let CurrentDate = new Date();
    let GivenDate = new Date(form["pickup_time"].value);
    if(GivenDate < CurrentDate){
        alert('Pickup date must be greater than the current date.');
        return false;
    }
}