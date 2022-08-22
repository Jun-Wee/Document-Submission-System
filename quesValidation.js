/**
* Author: Sandali Jayasinghe
* Target: enquiry.html
* Purpose: Validate data from MCQ answers
*/

"use strict";
function validateRadio(radio) {
   var val = false
   for ( var i = 0; i < radio.length; i++ ) {
      if ( radio[i].checked ) {
        val = true;
   }
   return val;
}

// make sure all questions are answered
function validateForm(theForm)
{
  var val = true;
  var unanswered = "";
  if (!validateRadio(theForm.q1)){
    val = false; unanswered += "Question 1\n";
  }
  if (!validateRadio(theForm.q2)){
    val = false; unanswered += "Question 2\n";
  }
  if (!validateRadio(theForm.q3)){
    val = false; unanswered += "Question 3\n";
  }
  if (!validateRadio(theForm.q4)){
    val = false; unanswered += "Question 4\n";
  }
  if (!validateRadio(theForm.q5)){
    val = false; unanswered += "Question 5\n";
  }
  if (!val){
     alert("Answer all of the questions\nThe following were unanswered:\n" + unanswered);
   }
  return val;
}

function init(){
	var mcqForm = document.getElementById("mcqform"); //formid
	mcqForm.onsubmit = validateForm;   // the function validate is called when the form is submitted.
}


/**the function init is called when the window loads*/
window.addEventListener("load",init);
