// This code provides two functions to the example app:

// validateForm()
//     This returns true if all inputs in the data form are valid or false if not.
//     Its role is to control submission so only a valid page can be sent to the server.
//     It operates by calling validate() as described below for each input element in turn.
//     Only if each and every field is valid will validateForm() return true.
//
// validate(inputElement)
//     This accepts a HTMLInputElement object and returns true if its value is valid or false if not.
//     The unique id itself is used to access the element value.

//   Whilst there are more advanced ways to achieve this, we check for the type we expect
//   This does mean some repetition of similar code, and that we can only test expected id's, but is straight forward to follow.

function validate(inputElement) {
    console.log("validate() called for inputElement:", inputElement);

    if (!inputElement) {
        // This error may be caused by calling document.getElementById()
        // but there is no HTML element with the id attribute value you provide
        console.error("validate() called with no input element");
        return false;
    }

    var feedbackElement = document.getElementById("feedback_" + inputElement.id);
    if (!feedbackElement) {
        // This error may be caused by adding an input with e.g. id="boop"
        // but no matching feedback element with e.g. id="feedback_boop"
        console.error(
            "validate() called but there is no element to provide feedback for this input"
        );
        return false;
    }

    var pattern; // regular expression to match input against
    var feedback; // feedback about input if it is invalid

    if (inputElement.id == "firstname") {
        // ^$ = anchors, [a-zA-Z0-9 ] = letters/digits/spaces, * = 0 or more characters
        pattern = /^[a-zA-Z0-9 ]*$/;
        feedback = "Only letters, numbers and spaces are permitted";
    }

    if (inputElement.id == "lastname") {
        // ^$ = anchors, [a-zA-Z0-9 ] = letters/digits/spaces, * = 0 or more characters
        pattern = /^[a-zA-Z0-9 ]*$/;
        feedback = "Only letters, numbers and spaces are permitted";
    }

    if (inputElement.id == "email") {
        // ^$ = anchors, .+ = 1+ of any character, \@ = one @ symbol
        pattern = /^.+\@.+$/;
        feedback = "Only valid email addresses are permitted";
    }
    
    if (inputElement.id == "bookref") {
        // ^$ = anchors, ([a-zA-Z]){3} = letters up to 3 characters, \- = must contain a dash,  ([0-9]){6} = numbers up to 6 characters
        pattern = /^[A-Z]{3}\-[0-9]{6}$/;
        feedback = "Only 3 lettler a - and 6 numbers are permitted, e.i. www-000000";
    }

    // Check that this is an input element we know how to validate
    if (!pattern) {
        // This error may be caused by adding an input with e.g. id="boop"
        // but no matching line above if (inputElement.id == "boop")...
        console.warn("validate() called but input id is not recognised");
        return false;
    }

    // Read the input value from the input element
    var value = inputElement.value;
    // Start by assuming the input is valid
    var valid = true;

    // Test the input value against the regular expression pattern
    if (pattern.test(value)) {
        feedback = "Valid";
        // Set the class attribute value of the feedback element to change its colour
        feedbackElement.className = "valid";
    } else {
        // Set the class attribute value of the feedback element to change its colour
        feedbackElement.className = "invalid";
        // The value is invalid
        valid = false;
    }

    // Show the feedback message on the page
    feedbackElement.innerText = "Client feedback: " + feedback;
    if (value != "") {
        // If there is a value, show this too
        feedbackElement.innerText += ": " + value;
    }
    return valid;
}

function validateForm() {
    // Start by assuming the form is valid
    var valid = true;

    // Validate each known input
    // Checks according to the inputs you expect
    valid = valid && validate(document.getElementById("firstname"));
    valid = valid && validate(document.getElementById("lastname"));
    valid = valid && validate(document.getElementById("email"));
    valid = valid && validate(document.getElementById("bookref"));

    // Feedback if form cannot be submitted
    if (!valid) {
        alert("Client message: Form data is invalid - please check and try again!");
    }
    return valid;
}
