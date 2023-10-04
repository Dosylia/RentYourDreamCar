"use strict";
import CreateAccount from "./Class/CreateAccount.js";

let btnSubmit;

function onClickBtnSubmit(event)
{
 
    let spans = document.querySelectorAll("span");
    for(const span of spans)
    {
        span.remove();
    }
    let inputs = document.querySelectorAll("input");
    let createaccount = new CreateAccount();
    createaccount.getInputs(inputs);
     
    if(createaccount._lastNameError == true || createaccount._firstNameError == true || createaccount._birthDayError == true || createaccount._birthMonthError == true || createaccount._birthYeatError == true || createaccount._addressError == true || createaccount._cityError == true || createaccount._zipCodeError == true || createaccount._phoneError == true || createaccount._mailError == true || createaccount.__passwordError == true || createaccount._passwordVerifError == true || createaccount._verifyPasswordSimilarityError == true)
    {
        event.preventDefault();
        console.log("Error champ ");
    }
    else
    {
        console.log("tout ok ");
    }
}


document.addEventListener("DOMContentLoaded",function(){

        btnSubmit = document.getElementById("submit");
        btnSubmit.addEventListener("click",onClickBtnSubmit);

})