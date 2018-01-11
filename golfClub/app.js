


var app = new Vue({
  el: '#application',
  data: {
      avDays: [],
      stage: "one",
      selectedDay: "",
      selectedTime: "",
      times: ["7:00", "7:10", "7:20", "7:30", "7:40", "7:50", "8:00", "8:10", "8:20"],
      userDanger: false,
      passwordDanger: false,
      userMessage: "",
      passwordMessage: "",
      username: "",
      password: "",
      loginAttempted: false,
      loginPassed: false,
      courseGuide: true,
      courseDetails: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18],
      currentImg: "img/hole1.jpg",
      courseImageBank: ["img/hole1.jpg", "img/hole2.jpg", "img/hole3.jpg", "img/hole1.jpg", "img/hole2.jpg", "img/hole3.jpg", "img/hole1.jpg", "img/hole2.jpg", "img/hole3.jpg", "img/hole1.jpg", "img/hole2.jpg", "img/hole3.jpg", "img/hole1.jpg", "img/hole2.jpg", "img/hole3.jpg", "img/hole1.jpg", "img/hole2.jpg", "img/hole3.jpg"],
      holeDesc: "Proin in ex non justo mollis tristique. Sed eleifend porttitor aliquet. Nam sapien sapien, gravida eget eros eu, viverra tempor risus. Mauris sed libero lorem. Nullam convallis enim ac quam luctus, vel hendrerit augue vehicula.",
      animateImg: true,
      animateDesc: true,
      curImgId: 0,
      mobileNav: false
    },
    methods: {
        //Find the next 5 days to be shown on the booking modal
        calcDays: function(){
        this.avDays = [];
        var d = new Date();
        var day = d.getDay();
        day+= 1;
        this.avDays.push("Today");
        for(var i = 0; i < 4; i++){
            var stringDate;
            if(day == 7){
                day = 0;
            }
            if(day == 0){
                this.avDays.push("Sunday");
            } else if (day == 1){
                this.avDays.push("Monday");
            } else if (day == 2){
                this.avDays.push("Tuesday");
            } else if (day == 3){
                this.avDays.push("Wednesday");
            } else if (day == 4){
                this.avDays.push("Thursday");
            } else if (day == 5){
                this.avDays.push("Friday");
            } else if (day == 6){
                this.avDays.push("Saturday");
            }
            day++;
        }
    },
        pickedDay: function(day){
            this.selectedDay = day;
            this.stage = "two"
        },
        //Reset all bind data and options relating to booking modal
        reset: function(){
            this.stage = "one"
            this.userDanger = false;
            this.passwordDanger = false,
            this.userMessage = "";
            this.passwordMessage = "";
            this.username = "";
            this.password = "";
            this.loginAttempted = false;
        },
        selectTime: function(e){
            this.selectedTime = e.target.parentElement.firstChild.textContent;
            this.stage = "three";
        },
        validate: function(){
                var self = this;
                this.loginAttempted = true;
                var user = this.userValidate();
                var pass = this.passwordValidate();
                if(user && pass){
                    //If user and password return true and pass validation, go to stage 4 (An ajax spinner), the to stage 5, an end message
                    this.stage = "four";
                    setTimeout(function(){
                       self.stage = "five"; 
                    }, 2000);
                }
        },
        userValidate: function(){
            //Only if log in attemped so form will not show errors from the offset i.e. because they will be empty and invalid otherwise
            if(this.loginAttempted){
            if(this.loginAttempted){
                if(this.username == ""){
                    this.userDanger = true;
                    this.userMessage = "Please enter a username";
                    return false;
                } else if(this.username.length < 4){
                    this.userDanger = true;
                    this.userMessage = "Username must be at least 4 characters long";
                    return false;
                } else {
                    this.userDanger = false;
                    return true;
                }
            }
            }
        },
        passwordValidate: function(){
            //Only if log in attemped so form will not show errors from the offset i.e. because they will be empty and invalid otherwise
            if(this.loginAttempted){
                if(this.password == ""){
                    this.passwordDanger = true;
                    this.passwordMessage = "Please enter a password (Any will do for the demo!)";
                    return false;
                } else if(this.password.length < 6){
                    this.passwordDanger = true;
                    this.passwordMessage = "Password must be at least 6 characters long (Any will do for the demo!)";
                    return false;
                } else {
                    this.passwordDanger = false;
                    return true;
                }
            }
        },
        //Change hole on course guide
        changeHole: function(key,e){
            var self = this;
            var hole = e.target.textContent;
            var hole = parseInt(hole);
            hole-=1;
            console.log(hole);
            this.animateImg = false;
            this.animateDesc = false;
            this.currentImg = this.courseImageBank[hole];
            //Timeout whilst old image animating out, then animate new image and text in
            setTimeout(function(){
                self.animateImg = true;
                self.animateDesc = true;
            }, 350);
            this.curImgId = key;
        },
        //Change hole on mobile view
        mobileChangeHole: function(way){
            var self = this;
            this.animateImg = false;
            this.animateDesc = false;
            if(way == "next"){
                if(self.curImgId == 17){
                    //Reset current image to 0 if it 17 (ths 18th hole)
                    self.curImgId = 0;
                } else {
                   self.curImgId+= 1;
                }
                
            } else if (way == "prev"){
                if(self.curImgId == 0){
                    //Set current imaget to 17 (the 18th hole) if pressing previous on the first hole
                    self.curImgId = 17;
                } else {
                   self.curImgId-= 1;
                }
            }
            self.currentImg = this.courseImageBank[self.curImgId];
            setTimeout(function(){
                self.animateImg = true;
                self.animateDesc = true;
            }, 350);
            
        },
        //Scroll to guide
        courseGuideShow: function(){
            this.courseGuide = true;
            $('html, body').animate({
                scrollTop: $("#mainButtonGroup").offset().top + 50
            }, 500);
        },
        //Hide course guide and scroll up
        courseGuideHide: function(){
            this.courseGuide = false;
            $('html, body').animate({
                scrollTop: $("#mainButtonGroup").offset().top - 100
            }, 500);
        }
    }
});



//Resets the "stage" (Stage of the booking process), back to one
$('#bookModal').on('hidden.bs.modal', function (e) {
    app.reset();
})


//For entry slides with vegas plugin
$("#slides, .slidesBody").vegas({
    autoplay: true,
    cover: true,
    slide: 0,
    slides: [
        { src: "img/slide1.jpg"},
        {src: "img/slide2.jpg"},
        {src: "img/slide3.jpg"},
        {src: "img/slide4.jpg"}
    ],
     overlay: 'vegas/overlays/03.png',
    transition: 'fade'
});




