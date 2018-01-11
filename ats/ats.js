
// Function to check if form field is empty. ID feilds require # in string
var isEmpty = function(warningType, formID, inputID, feedbackID, feedbackText){
   
$(formID).submit(function(event) {

var $username = $(inputID).val();
    
if($username !== ""){
    //remove bootstrap class
    $(inputID).removeClass("form-control-" + warningType);
    $(inputID).parent().removeClass("has-" + warningType);
    
    $(feedbackID).text("");
    
    } else {
    //Prevent sumbit if empty
    event.preventDefault();
    $(inputID).addClass("form-control-" + warningType);
    $(inputID).parent().addClass("has-" + warningType);
    //Update message
    $(feedbackID).text(feedbackText);
}
});  
}


// Same as above yet also checks that entry is a number as well as not empty
var isNan = function(warningType, formID, inputID, feedbackID, feedbackText){
   
$(formID).submit(function(event) {

var $entry = $(inputID).val();
    
if($entry !== "" && $.isNumeric($entry)){
    //remove bootstrap class
    $(inputID).removeClass("form-control-" + warningType);
    $(inputID).parent().removeClass("has-" + warningType);
    
    $(feedbackID).text("");
    
    } else {
    //Prevent sumbit if empty
    event.preventDefault();
    $(inputID).addClass("form-control-" + warningType);
    $(inputID).parent().addClass("has-" + warningType);
    //Update message
    $(feedbackID).text(feedbackText);
}
});  
}

//Check for login form
isEmpty("warning", "#loginForm", "#username", "#usernameFeedback", "Please enter a username");
isEmpty("warning", "#loginForm", "#password", "#passwordFeedback", "Please enter a password");

//Check for add new vacacny
isEmpty("warning", "#vacancyForm", "#vacancyName", "#vacancyNameFeedback", "Please enter a title");
isNan("warning", "#vacancyForm", "#vacancySalary", "#vacancySalaryFeedback", "Entry must be numeric only");

//Check for add new candidate
isEmpty("warning", "#candidateForm", "#firstName", "#firstNameFeedback", "Please enter a first name");
isEmpty("warning", "#candidateForm", "#surname", "#surnameFeedback", "Please enter a surname");
isNan("warning", "#candidateForm", "#phone", "#phoneFeedback", "Must be numeric only");
isEmpty("warning", "#candidateForm", "#email", "#emailFeedback", "Please enter an email");

//Check is empty for new comment added
isEmpty("warning", "#candidateCommentForm", "#newComment", "#newCommentFeedback", "Please enter a comment");

//Check for add new manager
isEmpty("warning", "#managerForm", "#managerFirstName", "#managerFirstNameFeedback", "Please enter a first name");
isEmpty("warning", "#managerForm", "#surname", "#surnameFeedback", "Please enter a surname");
isEmpty("warning", "#managerForm", "#title", "#titleFeedback", "Please enter a title");
isNan("warning", "#managerForm", "#phone", "#phoneFeedback", "Must be numeric only");
isEmpty("warning", "#managerForm", "#email", "#emailFeedback", "Please enter an email");


//Check for add new user
isEmpty("warning", "#userForm", "#username", "#usernameNameFeedback", "Please enter a username");
isEmpty("warning", "#userForm", "#password", "#passwordFeedback", "Please enter a password");




//Check windo height;
//var $height = $(window).height();
//var $width = $(window).width();
//
//if($width > 800 && $height > 400){
//    $(".sideNav").css("max-height", "500px");
//}
//
//if($width > 800 && $height > 400){
//    $(".subSideNav").css("max-height", "500px");
//}

//To disable CV upload function
document.getElementById("cvFile").disabled = true;




