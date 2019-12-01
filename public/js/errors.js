class Errors {
    
    constructor(errors,message){
        this.errors = document.querySelectorAll(errors);
        this.message = message;
        this.changeMsgErrors();
    }

    changeMsgErrors()
    {
        for (let i = 0; i < this.errors.length; i++){
            this.errors[i].textContent = this.message;
        }
    }
}