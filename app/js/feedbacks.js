var error = false;

function validateAvis(form) {
    error = false;
    var prenom = form.prenom;
    var note = form.note;
    var commentaire = form.commentaire;


    if (prenom.value === '') {
        setErrorFor(prenom, "Le prénom ne peut être vide");
    } else {
        setSuccess(prenom);
    }

    if (note.value === '') {
        setErrorFor(note, "Vous devez indiquer une note");
    } else {
        setSuccess(note);
    }

    if (commentaire.value === '') {
        setErrorFor(commentaire, "Le commentaire ne peut-être vide");
    } else {
        setSuccess(commentaire);
    }

    if (error == false) {
        form.submitF.submit();
    }
}

function validateQuestion(form) {
    error = false;
    var prenom = form.prenom;
    var question = form.question;


    if (prenom.value === '') {
        setErrorFor(prenom, "Le prénom ne peut être vide");
    } else {
        setSuccess(prenom);
    }

    if (question.value === '') {
        setErrorFor(question, "Vous devez poser une question");
    } else {
        setSuccess(question);
    }

    if (error == false) {
        form.submitF.submit();
    }
}

function setErrorFor(input, message) {
    error = true;
    var formControl = input.parentElement;
    var small = formControl.querySelector('small');
    small.innerHTML = message;
    formControl.className= "form-control error";
}

function setSuccess(input) {
    var formControl = input.parentElement;
    formControl.className= "form-control success";
}