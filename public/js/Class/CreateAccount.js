"use strict";

import ErrorSpan from "./ErrorSpan.js";

class CreateAccount{

    constructor(){
        this._lastName = "";
        this._firstName = "";
        this._birthDay = "";
        this._birthMonth = "";
        this._birthYear = "";
        this._address = "";
        this._city = "";
        this._zipCode = "";
        this._phone = "";
        this._mail = "";
        this._password = "";
        this._passwordVerif = "";

        this._lastNameError = false;
        this._firstNameError = false;
        this._birthDayError = false;
        this._birthMonthError = false;
        this._birthYearError = false;
        this._addressError = false;
        this._cityError = false;
        this._zipCodeError = false;
        this._phoneError = false;
        this._mailError = false;
        this._passwordError = false;
        this._passwordVerifError = false;
        this._verifyPasswordSimilarityError = false;
    }

    getInputs(inputs)
    {
       for(const input of inputs)
       {
        switch (input.id) {
            case "lastName":
                this.lastName = input;
                break;
            case "firstName":
                this.firstName = input;
                break;
            case "birthDay":
                this.birthDay = input;
                break;
            case "birthMonth":
                this.birthMonth = input;
                break;
            case "birthYear":
                this.birthYear = input;
                break;
            case "address":
                this.address = input;
                break;
            case "city":
                this.city = input;
                break;
            case "zipCode":
                this.zipCode = input;
                break;
            case "phone":
                this.phone = input;
                break;
            case "email":
                this.mail = input;
                break;
            case "password":
                this.password = input;
                break;
            case "passwordConfirm":
                this.passwordVerif = input;
                break;
            default:
                break;
        }

       }
    }


    
    set lastName(newLastName) {
        const regex = new RegExp(/^[a-zA-Z- éèà]{3,50}$/);

        if(newLastName.value == "")
        {
            let span = new ErrorSpan(newLastName.id,"Le champ ne doit pas etre vide ");
            span.displaySpan();
            this._lastNameError = true;
        } 
        else if(!regex.test(newLastName.value))
        {
            let span = new ErrorSpan(newLastName.id,"Le nom doit avoir au moins 3-50 lettres");
            span.displaySpan();
            this._lastNameError = true;   
        }
        else 
        {
            this._lastName = newLastName.value;
            this._lastNameError = false;
            console.log("LastName ok ");
        }
    }

    set firstName(newFirstName) {
        const regex = new RegExp(/^[a-zA-Z- éèà]{3,50}$/);

        if(newFirstName.value == "")
        {
            let span = new ErrorSpan(newFirstName.id,"Le champ ne doit pas etre vide ");
            span.displaySpan();
            this._firstNameError = true;
        } 
        else if(!regex.test(newFirstName.value))
        {
            let span = new ErrorSpan(newFirstName.id,"Le nom doit avoir au moins 3-50 lettres");
            span.displaySpan();
            this._firstNameError = true;   
        }
        else 
        {
            this._firstName = newFirstName.value;
            this._firstNameError = false;
            console.log("FirstName ok ");
        }
    }

    
    
    set birthDay(newBirthDay){

        const regex = new RegExp(/^([1-9]|[12][0-9]|3[01])$/);
        
        
        if(!regex.test(newBirthDay.value))
        {
            let span = new ErrorSpan(newBirthDay.id,"Le jour de naissance doit être compris entre 1 et 31");
            span.displaySpan();
            this._birthDayError = true;
        }
        else if(newBirthDay.value == "")
        {
            let span = new ErrorSpan(newBirthDay.id,"Le champ ne doit pas etre vide ");
            span.displaySpan();
            this._birthDayError = true;
        }
        else 
        {
            this._birthDay = newBirthDay.value;
            this._birthDayError = false;
            console.log("birthDay ok ");
        }

    }

    set birthMonth(newBirthMonth) 
    {

        const regex = new RegExp(/^([1-9]|1[0-2])$/);

        if(newBirthMonth.value == "")
        {
            let span = new ErrorSpan(newBirthMonth.id,"Le champ ne doit pas etre vide ");
            span.displaySpan();
            this._birthMonthError = true;
        } 
        else if(!regex.test(newBirthMonth.value))
        {
            let span = new ErrorSpan(newBirthMonth.id,"Le mois de naissance doit être entre 1 et 12");
            span.displaySpan();
            this._birthMonthError = true;   
        }
        else 
        {
            this._birthMonth = newBirthMonth.value;
            this._birthMonthError = false;
            console.log("birthMonth ok ");
        }
    }

    set birthYear(newBirthYear)
    {

        const regex = new RegExp(/^\d{4}$/);

        if(newBirthYear.value == "")
        {
            let span = new ErrorSpan(newBirthYear.id,"Le champ ne doit pas etre vide ");
            span.displaySpan();
            this._birthYeatError = true;
        } 
        else if(!regex.test(newBirthYear.value))
        {
            let span = new ErrorSpan(newBirthYear.id,"L'année de naissance n'est pas valide");
            span.displaySpan();
            this._birthYearError = true;   
        }
        else{
            this._birthYear = newBirthYear.value;
            this._birthYearError = false;
            console.log("birthYear ok ");
        }

    }

    set address(newAddress)
     {
        
        const regex = /^(?=.*\d)(?=.*[A-Za-z])(?=.*\s)[A-Za-z\d\s-,.#]+$/;
        
        if (newAddress.value == "")
        {
            let span = new ErrorSpan(newAddress.id,"Le champ ne doit pas être vide");
            span.displaySpan();
            this._addressError = true;       
        }
        else if (!regex.test(newAddress.value))
        {
            let span = new ErrorSpan(newAddress.id,"L'adresse n'est pas valide");
            span.displaySpan();
            this._addressError = true;       
        }
        else
        {
            this._address = newAddress.value;
            this._addressError = false;
            console.log("adresse ok ");
        }
    }

    set city(newCity)
    {

        const regex =  /^[A-Za-z- ]+$/;

        if (newCity.value == "")
        {
            let span = new ErrorSpan(newCity.id,"Le champ ne doit pas être vide");
            span.displaySpan();
            this._cityError = true;       
        }
        else if (!regex.test(newCity.value))
        {
            let span = new ErrorSpan(newCity.id,"La ville n'est pas valide");
            span.displaySpan();
            this._cityError = true;       
        }
        else
        {
            this._city = newCity.value;
            this._cityError = false;
            console.log("city ok ");
        }
    }

    set zipCode(newZipCode)
    {

        const regex =   /^\d{5}(-\d{4})?$/;

        if (newZipCode.value == "")
        {
            let span = new ErrorSpan(newZipCode.id,"Le champ ne doit pas être vide");
            span.displaySpan();
            this._zipCodeError = true;       
        }
        else if (!regex.test(newZipCode.value))
        {
            let span = new ErrorSpan(newZipCode.id,"Le code postal n'est pas valide");
            span.displaySpan();
            this._zipCodeError = true;       
        }
        else
        {
            this._zipCode = newZipCode.value;
            this._zipCodeError = false;
            console.log("zipcode ok ");
        }
    }

    set phone(newPhone)
    {

        const regex =  /^\d{10}$|^(\d{3}[-\s]?){2}\d{4}$/;

        if (newPhone.value == "")
        {
            let span = new ErrorSpan(newPhone.id,"Le champ ne doit pas être vide");
            span.displaySpan();
            this._phoneError = true;       
        }
        else if (!regex.test(newPhone.value))
        {
            let span = new ErrorSpan(newPhone.id,"Le numéro de téléphone n'est pas valide");
            span.displaySpan();
            this._phoneError = true;       
        }
        else
        {
            this._phone = newPhone.value;
            this._phoneError = false;
            console.log("phone ok ");
        }
    }

    set mail(newMail)
    {

        const regex =   /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,}$/;

        if (newMail.value == "")
        {
            let span = new ErrorSpan(newMail.id,"Le champ ne doit pas être vide");
            span.displaySpan();
            this._mailError = true;       
        }
        else if (!regex.test(newMail.value))
        {
            let span = new ErrorSpan(newMail.id,"L'adresse mail n'est pas valide");
            span.displaySpan();
            this._mailError = true;       
        }
        else
        {
            this._mail = newMail.value;
            this._mailError = false;
            console.log("mail ok ");
        }
    }

    set password(newPassword)
    {

        const regex = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%?&])[A-Za-z\d@$!%?&]{8,}$/;

        if (newPassword.value == "")
        {
            let span = new ErrorSpan(newPassword.id,"Le champ ne doit pas être vide");
            span.displaySpan();
            this._passwordError = true;       
        }
        else if (!regex.test(newPassword.value))
        {
            let span = new ErrorSpan(newPassword.id,"Le mot de passe 1 n'est pas valide");
            span.displaySpan();
            this._passwordError = true;       
        }
        else
        {
            this._password = newPassword.value;
            if (this.verifyPasswordSimilarity() == true )
            {
            this._passwordError = false;
            console.log("password ok ");
            } 
            else 
            {
            let span = new ErrorSpan(newPassword.id,"Les mots de passe sont différent");
            span.displaySpan();
            this._verifyPasswordSimilarityError = true;  
            }
        }
    }

    set passwordVerif(newPasswordVerif)
    {
        // mot de passe test : MonMotDePasse1$
        const regex = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%?&])[A-Za-z\d@$!%?&]{8,}$/;
        
        if (newPasswordVerif.value == "")
        {
            let span = new ErrorSpan(newPasswordVerif.id,"Le champ ne doit pas être vide");
            span.displaySpan();
            this._passwordVerifError = true;       
        }
        else if (!regex.test(newPasswordVerif.value))
        {
            let span = new ErrorSpan(newPasswordVerif.id,"Le mot de passe 2 n'est pas valide");
            span.displaySpan();
            this._passwordVerifError = true;       
        }
        else
        {
            this._passwordVerif = newPasswordVerif.value;
        }
    }

    verifyPasswordSimilarity()
    {
        if(this._password && this._passwordVerif && this._password !== this._passwordVerif)
        {
            return false;
        }
         else
        {
            return true;
        }
    }

}

export default CreateAccount;