let dateResaInput;

function setDate(){

    let date = new Date();
    let year = date.getFullYear();
    let month = String(date.getMonth() + 1).padStart(2, '0');
    let day = String(date.getDate()).padStart(2, '0');

    let dateFormat = `${year}-${month}-${day}`;
    
    dateResaInput.value = dateFormat;
    dateResaInput.min = dateFormat;

}

document.addEventListener("DOMContentLoaded", ()=>{
    dateResaInput = document.getElementById("dateResa");
    setDate();

})