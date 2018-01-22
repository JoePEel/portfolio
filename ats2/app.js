  // Initialize Firebase
var config = {

  };
firebase.initializeApp(config);
    

new Vue({
      el: '#app',
      data: {
        candidates: [],
        dialog: false,
    isReady: false,
    firstName: "",
    surename: "",
    email: "",
    conNumber: "",
    search: "",
    singleView: false,
    single: {
        name: "",
        email: "",
        key: "",
        log: [],
        number: ""
    },
    newVacModal: false,
    vacancy: {
        name: "",
        spec: "",
        key: "",
    },
    vacanciesLoad: [],
    active: "tab-1",
    singleVacView: false,
    singleVacDetails: {
        title: "",
        spec: "",
        key: "",
        prospects: [],
        sentCvs: [],
        prosCount: "",
        cvSentCount: "",
        interviewCount: ""
    },
    prospectSelect: [],
    prospectChoice: "",
    canComment: "",
    bookInterviewModal: false,
    interviewTime: "",
    interviewDate: "",
    interviewModalText: "",
    interviewCanKey: "",
    ineterviewCanName: "",
    allInerviews: [],
    singleVacInterviews: false,
    vacanciesList: true,
    curTime: "",
    edit: {
        emailShow: false,
        phoneShow: false,
        specShow: false
    },
    allActiveClass: true,
    twoWeeksActiveClass: false,
    upcomingActiveClass: false,
    snackbar: false,
    snackbarText: "",
    snackbarTimeout: 1500
    },
    computed: {
        passedCanVal: function(){
          if(this.firstName.length > 2 && this.surename.length > 2){
              return true;
          } else {
              return false;
          }
        },
        passedVacVal: function(){
          if(this.vacancy.name.length > 2){
              return true;
          } else {
              return false;
          }
      }  
        
        
    },
    methods: {
        //Add new candidate
        submit: function(){
            var newkey = firebase.database().ref("candidates").push().key;
            firebase.database().ref("candidates/"  + newkey).set({
                firstName: this.firstName,
                surename: this.surename,
                email: this.email,
                number: this.conNumber
            });
            this.dialog = false;
            this.candidates = [];
            this.load();
        },
        
        //Load candidates
        load: function(){
            var self = this;
            firebase.database().ref("candidates").on("child_added", function(snap){
                var ob = {
                    name: snap.val().firstName + " " + snap.val().surename,
                    email: snap.val().email,
                    key: snap.key,
                    log: snap.val().log
                }
                self.candidates.unshift(ob);
            });
        },
        
        //Search candidates
        searchCan: function(){
            var searchLength = this.search.length;
            var search = this.search;
            var self = this;
            //Only if search 3 characters or more
            if(searchLength > 2){
                self.candidates = [];
                 firebase.database().ref("candidates").orderByChild("surename").startAt(search).endAt(search + "\uf8ff").on("child_added", function(snap){
                    var ob = {
                        name: snap.val().firstName + " " + snap.val().surename,
                        email: snap.val().email,
                        key: snap.key
                    }
                    self.candidates.push(ob);
                });
            } else {
                this.candidates = [];
                this.load();
            }
        },
        
        //Load full candidate details
        full: function(key){
            var self = this;
            self.single.log = [];
            
            //Get candidates
             firebase.database().ref("candidates/" + key).once("value", function(snap){
                 self.single.name = snap.val().firstName + " " + snap.val().surename;
                 self.single.email = snap.val().email;
                 self.single.number = snap.val().number;
                 self.single.key = snap.key; 
             });
            
            //Get log
            firebase.database().ref("candidates/" + key + "/log").orderByChild("timeStamp").on("child_added", function(snap){
                self.single.log.unshift(snap.val());
            });
            console.log(self.single.log);
            this.singleView = true;
            this.active = "tab-1"
        },
        //Close candidate single view
        goBack: function(){
            this.singleView = false;
            this.edit.emailShow = false;
            this.edit.phoneShow = false;
            this.prospectChoice = "";
            this.canComment = "";
        },
        //Add new vacancy
        submitNewVac: function(){
            var newkey = firebase.database().ref("vacancies").push().key;
            firebase.database().ref("vacancies/"  + newkey).set({
                title: this.vacancy.name,
                spec: this.vacancy.spec,
                prospectCount: 0,
                cvSentCount: 0,
                interviewCount: 0
            });
            this.newVacModal = false;
        },
        //Load all vacancies
        vacancyLoad: function(){
            var self = this;
            firebase.database().ref("vacancies").on("child_added", function(snap){
                var ob = {
                    title: snap.val().title,
                    spec: snap.val().spec,
                    pros: snap.val().prospectCount,
                    cvs: snap.val().cvSentCount,
                    interviews: snap.val().interviewCount,
                    key: snap.key
                }
                
                var selectOb = {
                    value: snap.key,
                    text: snap.val().title
                }
                self.prospectSelect.unshift(selectOb);
                self.vacanciesLoad.unshift(ob);
                
            });
        },
        swap: function(){
            this.active = "tab-1";
        },
        
        //View single vacancy
        viewSingleVac: function(key){
            var self = this;
            this.singleVacDetails.prospects = [];
            this.singleVacDetails.sentCvs = [];
            
            //Get vacancy
            firebase.database().ref("vacancies/" + key).once("value", function(snap){
                self.singleVacDetails.title = snap.val().title;
                self.singleVacDetails.spec = snap.val().spec;
                self.singleVacDetails.prosCount = snap.val().prospectCount;
                self.singleVacDetails.cvSentCount = snap.val().cvSentCount;
                self.singleVacDetails.interviewCount = snap.val().interviewCount;

             });
            
            //Get vacancy prospects
            firebase.database().ref("vacancies/" + key + "/prospects").on("child_added", function(snap){
                self.singleVacDetails.prospects.unshift(snap.val());
            });
            
            //Get vacancy sent CVs
            firebase.database().ref("vacancies/" + key + "/sentCvs").on("child_added", function(snap){
                self.singleVacDetails.sentCvs.unshift(snap.val());
            });
            
            this.singleVacDetails.key = key;
            this.singleVacView = true;
            this.active = "tab-2";
        },
        
        //Close single vacancy view
        closeSingleVacancy: function(){
            this.edit.specShow = false;
            this.singleVacView = false;
        },
        
        //Prospect candidates
        prospectCan: function(){
            if(this.prospectChoice != ""){
                var self = this;
                var prosOb = {};
                
                //Add to prospects
                firebase.database().ref("vacancies/"  + self.prospectChoice + "/prospects/" + self.single.key).set({
                    canKey: self.single.key,
                    name: self.single.name
                    
                });
                
                //Get vacancy
                firebase.database().ref("vacancies/" + self.prospectChoice).once("value", function(snap){
                    prosOb = {
                        vacKey: snap.key,
                        title: snap.val().title,
                        pros: snap.val().prospectCount
                    }
                });
                
                //Increase prospct count
                var newProsCount = prosOb.pros + 1;
                
                //Update prospect count
                firebase.database().ref("vacancies/" + self.prospectChoice).update({
                    prospectCount: newProsCount
                });
                
                //Update specific candidates list of roles they've been prospected for
                var newCankey = firebase.database().ref("candidates/"  + self.single.key + "/prospects").push().key;
                firebase.database().ref("candidates/"  + self.single.key + "/prospects/" + self.prospectChoice).set({
                    vacKey: prosOb.vacKey,
                    title: prosOb.title
                });
                
                this.addToCanLog(self.single.key, "Prospected for " + prosOb.title);
                this.prospectSelect = [];
                this.vacanciesLoad = [];
                this.vacancyLoad();
                this.launchSnackbar("Prospected for " + prosOb.title);
            }
        },
        //Add candidate comment
        subCanComment: function(){
            var comment = this.canComment;
            if(comment != ""){
                this.addToCanLog(this.single.key, comment);
                this.canComment = "";
                this.launchSnackbar("Comment Added");
            }
            
        },
        
        //Update candidate details
        updateCanDetails: function(field){
    
            var self = this;
            if(field == "email"){
                firebase.database().ref("candidates/"  + self.single.key).update({
                    email: self.single.email
                });
                self.launchSnackbar("Email updated");
                this.edit.emailShow = false;
            } else if (field == "number"){
                firebase.database().ref("candidates/"  + self.single.key).update({
                    number: self.single.number
                });
                self.launchSnackbar("Contact number updated");
                this.edit.phoneShow = false;
            }

        },
        //Launch snackbar
        launchSnackbar: function(msg){
            this.snackbarText = msg;
            this.snackbar = true;
        },
        //Update vacancy spec
        updateVacSpec: function(){
            var self = this;
            firebase.database().ref("vacancies/"  + self.singleVacDetails.key).update({
                    spec: self.singleVacDetails.spec
            });
            this.launchSnackbar("Spec updated");
            this.edit.specShow = false;
        },
        //Mark CV as sent
        sendCV: function(key, i, name){
            var self = this;
            //Remove from prospects list
            firebase.database().ref("vacancies/" + self.singleVacDetails.key + "/prospects/"   + key).remove();
            
            //Remove from prospects list
            this.singleVacDetails.prospects.splice(i, 1);
            
            //Mark under vacacny record of new CV sent
            firebase.database().ref("vacancies/"  + self.singleVacDetails.key + "/sentCvs/" + key).set({
                canKey: key,
                name: name
            });
            
            //Update CV sent count
            var newCvCount = self.singleVacDetails.cvSentCount + 1;
            //Update prospect count
            var newProspectCount = self.singleVacDetails.prosCount - 1;
            
            //Update on firebase new CV sent and prospect count
            firebase.database().ref("vacancies/" + self.singleVacDetails.key).update({
                cvSentCount: newCvCount,
                prospectCount: newProspectCount
            });
            
            this.addToCanLog(key, "CV sent for " + self.singleVacDetails.title);
            this.prospectSelect = [];
            this.vacanciesLoad = [];
            this.vacancyLoad();
        },
        //Go to interviews page and load interviews specific to that vacancy
        viewVacInterviews: function(){
            this.active = "tab-3";
            var self = this;
            this.allInerviews = [];
            this.singleVacInterviews = true;
            firebase.database().ref("vacancies/" + self.singleVacDetails.key + "/interviews").orderByChild("timeStamp").on("child_added", function(snap){
                    self.allInerviews.push(snap.val());
                    console.log(snap.val());
                });
        },
        //Controls for viewing different interviews
        viewInterview(type){
            var self = this;
            self.allInerviews = [];
            self.singleVacInterviews = false;
            var time =  new Date().getTime();
            self.vacanciesList = false;
            
          if(type == "all") {
            firebase.database().ref("interviews").orderByChild("timeStamp").on("child_added", function(snap){
                    self.allInerviews.push(snap.val());
                });
            self.allActiveClass = true;
            self.upcomingActiveClass = false;
            self.twoWeeksActiveClass = false;
              
          } else if (type == "upcoming"){
                firebase.database().ref("interviews").orderByChild("timeStamp").startAt(time).on("child_added", function(snap){
                    self.allInerviews.push(snap.val());
                });
            self.allActiveClass = false;
            self.upcomingActiveClass = true;
            self.twoWeeksActiveClass = false;
              
          } else if (type == "twoweeks"){
                var twoWeeksAgo = time - (1000 * 60 * 60 * 24 * 7 * 2);
                firebase.database().ref("interviews").orderByChild("timeStamp").startAt(twoWeeksAgo).endAt(time).on("child_added", function(snap){
                    self.allInerviews.push(snap.val());
                });
            self.allActiveClass = false;
            self.upcomingActiveClass = false;
            self.twoWeeksActiveClass = true;
          }
            setTimeout(function(){
                self.vacanciesList = true;
            }, 300);
        },
        //Book interview
        bookInterview: function(key){
            console.log(key);
            this.active = "tab-3"
            this.bookInterviewModal = true;
            var self = this;
            this.interviewCanKey = key;
            
            //Get specific candidate details and launch interivew booking modal
            firebase.database().ref("candidates/" + key).once("value", function(snap){
                self.interviewModalText = "Confirm time and date for " + snap.val().firstName + " to interview for " + self.singleVacDetails.title + " position";
                self.ineterviewCanName = snap.val().firstName + " " + snap.val().surename;0
            });
            var newInterviewCount = self.singleVacDetails.prosCount + 1;
            
            firebase.database().ref("vacancies/" + self.singleVacDetails.key).update({
                    interviewCount: newInterviewCount
                });
        },
        //Cancel interview
        cancelInterview: function(){
            this.bookInterviewModal = false;
            this.active = "tab-2";
        },
        //Confirm interview
        confirmInterview: function(){
            if(this.interviewTime != "" && this.interviewDate){
            var self = this;
            var timeStamp =  new Date(this.interviewDate).getTime();
            var jsDate = new Date(this.interviewDate);
            var formatDate = jsDate.toDateString();
            
            //Add interview to firebase under vacancy
            firebase.database().ref("vacancies/" + self.singleVacDetails.key + "/interviews/" + self.interviewCanKey).set({
                    canName: self.ineterviewCanName,
                    canKey: self.interviewCanKey,
                    vacName: self.singleVacDetails.title,
                    vacKey: self.singleVacDetails.key,
                    date: formatDate,
                    time: self.interviewTime,
                    timeStamp: timeStamp
            });
            //Add interview to firebase under candidate   
            firebase.database().ref("candidates/" + self.interviewCanKey + "/interviews/" + self.singleVacDetails.key).set({
                    vacName: self.singleVacDetails.title,
                    vacKey: self.singleVacDetails.key,
                    date: formatDate,
                    time: self.interviewTime,
                    timeStamp: timeStamp
            });
                
            //Add interview to firebase under general interviews
            var newKey = firebase.database().ref("interviews").push().key;    
           firebase.database().ref("interviews/" + newKey).set({
                    vacName: self.singleVacDetails.title,
                    vacKey: self.singleVacDetails.key,
                    canName: self.ineterviewCanName,
                    canKey: self.interviewCanKey,
                    date: formatDate,
                    time: self.interviewTime,
                    timeStamp: timeStamp
            });   
            
            //Update sent CVs under vancies view to show as interview is booked
            firebase.database().ref("vacancies/"  + self.singleVacDetails.key + "/sentCvs/" + self.interviewCanKey).set({
                canKey: self.interviewCanKey,
                name: self.ineterviewCanName,
                interview: "yes"
            });
                
            this.bookInterviewModal = false;
            
            //Increase interview count
            var newInterviewCount = self.singleVacDetails.interviewCount + 1;
            
            //Update interview count
            firebase.database().ref("vacancies/" + self.singleVacDetails.key).update({
                    interviewCount: newInterviewCount
            });
                
                
            this.addToCanLog(self.interviewCanKey, "Interview booked for " + self.singleVacDetails.title);
            this.prospectSelect = [];
            this.vacanciesLoad = [];
            this.vacancyLoad();
            this.launchSnackbar("Interview booked for " + self.singleVacDetails.title);
            this.singleVacView = false;
                
            }
        },
        //Get all interviews
        fetchInterviews: function(){
            var self = this;
            self.allInerviews = [];
            self.singleVacInterviews = false;
            self.vacanciesList = false;
            firebase.database().ref("interviews").orderByChild("timeStamp").on("child_added", function(snap){
                    self.allInerviews.push(snap.val());
                    console.log(snap.val());
                });
            
            setTimeout(function(){
                self.vacanciesList = true;
            }, 300);
        },
        //Get date for timestamp
        getDate: function(){
            this.curTime = new Date(timeS);
        },
        //Add to candidate log
        addToCanLog: function(key, message){
            var d = new Date();
            var dateString = d.toLocaleDateString();
            var time = d.getTime();
            var newkey = firebase.database().ref("candidates/" + key + "/log").push().key;
            firebase.database().ref("candidates/" + key + "/"  + "/log/" + newkey).set({
                message: dateString + " - " + message,
                timeStamp: time
            });
        }
                                                                                          
    },
    beforeMount: function(){
        this.load();
        this.vacancyLoad();
        this.fetchInterviews();
    },
    mounted: function(){
        this.isReady = true;
    }

});
