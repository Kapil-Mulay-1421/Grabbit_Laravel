// Animations:

let swoopCategory = (entries, observer) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.children[0].classList.add("scrolled");
        }
    })
}
let observer = new IntersectionObserver(swoopCategory, {threshold: 0.5});
const categoryWrappers = document.getElementsByClassName("category-wrapper");
Array.from(categoryWrappers).forEach(categoryWrapper => {
    let target = categoryWrapper;
    observer.observe(target);
})

// Functions

window.subscribe = function(e) {
    e.preventDefault();
    const email = document.getElementById('email-collection-input-box').value;
    // checking email validity
    let validInput = true;
    let i = 0;
    if (email.length == 0) {
        validInput = false;
    }
    while (i<email.length){
        if (email.charAt(i) == '@' && i != 0) {
            i = 0;
            break;
        }
        else {
            i += 1;
        }
        if (i == email.length){
            validInput = false;
            i = 0;
            break;
        }
    }
    if (!validInput) {
        document.getElementById('afterSubmit').innerHTML = "Please input a valid email.";
        document.getElementById('afterSubmit').style.display = "block";
        return;
    } else {
        document.getElementById('subscribe-form').submit();
    }

    /*const subRequest = new XMLHttpRequest()
    subRequest.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 201) {
            document.getElementById('afterSubmit').innerHTML = "Thanks for submitting!";
            document.getElementById('afterSubmit').style.display = 'block';
        } else if (this.readyState == 4 && this.status == 409) {
            document.getElementById('afterSubmit').innerHTML = "Already Registered";
            document.getElementById('afterSubmit').style.display = 'block';
        } else if(this.readyState == 4) {
            console.log("Got status code " + this.status + ", Idk why. Best of luck trying to figure it out!");
        }
    }
    subRequest.open("POST", "/subscribers")
    subRequest.send(JSON.stringify(email));*/
}
