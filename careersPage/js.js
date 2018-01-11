/////////
//Model//
/////////
var model = (function(){
    
    return {
        
        //General insert to DB function
      insertToDb: function(data){
         return $.ajax({
              url: "includes/database/insert.php",
             type: "POST",
              data: data
          });
      },
        
        //Get results from DB, must use "getAction" to determin DB response
        getFromDb: function(data){
           return $.ajax({
                type: "GET",
                data: data,
                dataType: "json",
                url: "includes/database/tabledata.php"
            });
        },
        
        //Get file, typically html bunch
        getFile: function(file){
           return $.ajax({
                url: file
            });
        },
        
        //Submit Application
        submitApplictaionForm: function(formData){
           return $.ajax({
                url: "includes/database/application.php",
                data: formData,
                type: "POST",
                contentType: false,
                processData: false
            });
        },
        
        //Submit blog post
        submitOrEditBlogForm: function(formData){
           return $.ajax({
                url: "includes/database/addEditBlog.php",
                data: formData,
                type: "POST",
                contentType: false,
                processData: false
            });
        },
        
        //Submit edit of blog post
        editBlogPost: function(formData){
           return $.ajax({
                url: "includes/database/editBlogPost.php",
                data: formData,
                type: "POST",
                contentType: false,
                processData: false,
                success: function(resp){
                    console.log(resp);
                }
            });
        },
        
        //Ajax applicant search
        seachForApp: function (data) {
                return $.ajax({
                type: "GET",
                data: data,
                dataType: "json",
                url: "includes/database/appsearch.php",
                before: function(){
                    $("#adminContent").html("");
                    var loading = "<p>Loading</p>";
                    (loading).appendTo("$#adminContent");
                },
                success: function(){
                    $("#adminContent").html("");
                }
            });
        },
        
        //Add vacancy to db
        addVac: function(formData){
           return $.ajax({
                url: "includes/database/addVac.php",
                data: formData,
                type: "POST",
                contentType: false,
                processData: false,
                success: function(resp){
                    console.log(resp);
                }
            });
        },
        
        //Submit edit of vacancy
        editVac: function(formData){
           return $.ajax({
                url: "includes/database/editVac.php",
                data: formData,
                type: "POST",
                contentType: false,
                processData: false
            });
        }
    };
    
    
})();


////////
//View//
////////
var view = (function(){
    //For id of ajax generated divs containing applicant information
    var idIndex = 0;
    var blogIdIndex = 0;
    
    return {
        
        //Load current vacancies
        loadVacsHome: function(data){
            var div = $("#currentVacancies");
            $.each(data, function(i, key){
            //Show only preview of job description
            var desc = key.vac_desc.substr(0, 100);
                var html = '<div class="vacanciesOverview col-lg-4 col-md-6"><h4>' + key.vac_name + '</h4><p>' + desc + '</p><br><button id=' + key.vac_id + ' class="fullDetails">Full Details</button></div>';
                $(html).appendTo(div);
                });
        },
        
        //Load single vacacncy full details to home
        loadVacFullDetails: function(data){
            var div = $("#currentVacancies");
            div.html("");
            var html = "<div><button class=\"backToVacs\">Back</button></div><div class=\"singleVacacnyOverview\"><h4>" + data[0].vac_name + "</h4><h5>Post on: " + data[0].vac_date + "</h5><p>" + data[0].vac_desc + "</p><button id=\"" + data[0].vac_id + "\" class=\"apply\">Apply</button></div>";
            $(html).appendTo(div);
        },
        
        //Load application form
        appendApplicationForm: function(data){
            $("#currentVacancies").html("");
            $(data).appendTo("#currentVacancies");
        },
        
        //Append sent message current vacacnies
        appendSubmitSuccess: function(){
            var message = "<div class='row messageSuccessContainer'><p class='messageSuccess'>You\'re CV has been submitted and will be reviewed by our team soon</p></div>";
            $(message).appendTo("#currentVacancies");
        },
        
        
        //Load blog posts to front end of site
        loadBlogPosts: function(data){
            var div = $("#blogPostsPage");
            if(div.html = ""){
                blogIdIndex = 0;
            }
            $.each(data, function(i, key){
            var html = "<div id=\"" + key.blog_id + "\" class=\"blogOverview blogOverviewHome\"><h2>" + key.blog_title + "</h2><h5>Post on: " + key.blog_date + "</h5><p>" + key.blog_content + "</p><hr></div>";
                $(html).hide().appendTo(div).fadeIn("slow");
                idIndex++;
            });
        },
        
        getBlogLastId: function(){
            return $(".blogOverview").length;
           
        },
        
        //Animated scroll to id 
        animateScroll:  function(id, offset){
            $("html, body").animate({
                scrollTop: ($("#" + id).offset().top - offset)
            }, 500);  
        },
        
        //
        //For admin
        //
        
        
        //Load Applicants
        loadApps: function(data){
            var div = $("#adminContent");
            if(div.html = ""){
                idIndex = 0;
            }
            $.each(data, function(i, key){
            var html = "<div id=\"" + idIndex + "\" class=\"appOverview\"><div class=\"appFirstLine\"><p>Id: " + key.app_id + "</p><p><span class=\"bold\">" + key.app_fname + " " + key.app_sname + "</span> applied to " + key.vac_name + " on " + key.app_date + "</p></div><div class='appSecondLine'<p>" + key.app_tel + "</p><p>" + key.app_email + "</p><button class=\"viewCv\" disabled>CV</button></div></div><hr>";
                $(html).hide().appendTo(div).fadeIn("slow");
                idIndex++;
            });
        },
        
        //Get last idea of loadApps() contents
        getAppLastId: function(){
            return $(".appOverview").length;
        },
        
        clearAdminContent: function(){
            $("#adminContent").html("");
            $("#adminSubNav").html("");
        },
        
        //Show search box in adim area
        loadSearchField: function(){
            $("<input type='text' id='searchForApp' placeholder='search'>").appendTo("#adminSubNav");
        },
        
        clearIdIndex: function(){
            idIndex = 0;
        },
        
        //Highlight active link
        adminNavActive: function(target){
            $("#topNav ul li").removeClass("active");
            $(target).addClass("active");
        },
        
        //Reset id index for ajax scrill loading
        resetIdIndex: function(){
            idIndex = 0;
        },
        
        adminLoadVacs: function(data){
            var div = $("#adminContent");
            $.each(data, function(i, key){
                var html = "<div class=\"adminVacOverview\" id=\"" + key.vac_id + "\"><div class=\"rowTitle\"><h4>" + key.vac_name + "</h4><p> Posted on " + key.vac_date + "<p></div><div class=\"btnRow\"><button class=\"viewAppsFromVacs\">View Applicants</button><button class=\"vacEdit\">Edit</button><button class=\"deleteVac\" disabled>Delete</button></div></div><hr>";
                $(html).appendTo(div);
            });
        },
        
        loadBackToVacsBtn: function(){
            $("<button class='backToVacsBtn'>Back</button>").appendTo("#adminContent");
        },
        
        //For loading blog posts to admin
        adminLoadBlogPosts: function(data){
            var div = $("#adminContent");
            $.each(data, function(i, key){
                var conent = key.blog_content.substr(0, 200);
                var html = "<div class=\"blogOverview blogOverviewAdmin hoverBlue\" id=\"" + key.blog_id + "\"><div class=\"blogTitleInfo\"><h4>" + key.blog_title + "</h4><p>" + key.blog_date + "</p></div><p>" + conent + "</p><button class=\"blogEdit\">Edit</button><button class=\"deleteBlog\" disabled>Delete</button></div><hr>";
                $(html).appendTo(div);
            });
        },
        
        addNewBlogBtn: function(){
            $("<div class='addNewBlogPostDiv'><button class='addNewBlogPostBtn'>Add New</button></div>").appendTo("#adminSubNav");
        },
        
        editBlogView: function(data){
            $("#blogTitle").val(data[0].blog_title);
            $("#blogContent").val(data[0].blog_content);
            $(".blogPostContainer").attr("id", data[0].blog_id);
        },
        
        //Success message to display when blog updated
        editBlogSuccess: function(mess){
            var message = "<div class='editSuccess'><p>" + mess + "</p><div>";
            $(message).appendTo("#adminContent");
        },
        
        destroyBlogSuccess: function(){
            $(".editSuccess p").remove();
        },
        
        addNewVacBtn: function(){
            $("<div class='addNewVacDiv'><button class='addNewVacBtn'>Add New</button></div>").appendTo("#adminSubNav");
        },
        
        //Edit vacancy view
        editVacView: function(data){
            $("#vacTitle").val(data[0].vac_name);
            $("#vacContent").val(data[0].vac_desc);
            $(".editVacContainer").attr("id", data[0].vac_id);
        },
        
        //Append ajax loader to dom
        appendAjaxLoader: function(){
            $('<div id="ajaxLoader"><img src="img/ajax-loader.gif"></div>').insertAfter("#adminContent");
            $("#ajaxLoader").hide();
        },
        
        //Remove ajax gif from dom
        removeAjaxLoader: function(){
            $("#ajaxLoader").remove();
        }

    }
    
})();


//////////////
//Controller//
//////////////
var controller = (function(m, v){
    
    //For stroing relevant vacancy ID when load full details and application form
    var vacId;
    var isWorking = false;
    var searchEnabled = false;
    var blogIsWorking = false;
    var appPage = true;
    var blogPage = false;
    
    
    //Load current vacancies to main page
    function controllerLoadCurrentVacs(){
            $("#currentVacancies").html("");
            m.getFromDb({
                getAction: "getVacs"
            }).done(function(resp){
               v.loadVacsHome(resp); 
            });
    }
    
    //Load blog posts to site
    function loadBlogPostsPage(lastid, limit){
        $("#ajaxLoader").show();
        m.getFromDb({
        getAction: "getBlogPostsPage",
        lastId: lastid,
        limit: limit
            }).done(function(resp){
                $("#ajaxLoader").hide();
                v.loadBlogPosts(resp);
                blogIsWorking = false;
                if(resp == ""){
                    $("#ajaxLoader").remove();
                }
            });
    }
    
    //Load individual vacancy
    $(document).on("click", ".fullDetails", function(e){
            vacId = this.id;
        m.getFromDb({
            getAction: "getSingleVac",
            id: vacId
        }).done(function(resp){
            v.loadVacFullDetails(resp);
            v.animateScroll("vacanciesnav", 0);
        });
    });
    
    //Load application form when pressign apply
    $(document).on("click", ".apply", function(e){
            var id = this.id
            m.getFile("includes/markup/form.html").done(function(resp){
            v.appendApplicationForm(resp);
            v.animateScroll("vacanciesnav", 0);
            $("#firstNameApplication").focus();
        });
    });
    
    //Submit Application Form
    $(document).on("click", "#submitApplicationBtn", function(e){
            
            var form = $("#submitApplicationForm");
            var formtrue = document.getElementById("submitApplicationForm").checkValidity();
            if(formtrue){
                e.preventDefault();
                var formData = new FormData(document.getElementById("submitApplicationForm"));
                formData.append("vacId", vacId);
                m.submitApplictaionForm(formData);
                controllerLoadCurrentVacs();
                v.appendSubmitSuccess();
            }
    });
        
    //Load previous vacacnies on back button
    $(document).on("click", ".backToVacs", function(e){
        controllerLoadCurrentVacs();
    });
    
    //Ajax lazy load blog posts
    $(window).scroll(function() {
       if($(window).scrollTop() + $(window).height() > $(document).height() - 200) {
           if(!blogIsWorking){
               blogIsWorking = true;
                var finalId = v.getBlogLastId();
               loadBlogPostsPage(finalId, 3);
       }
       }
    });
    
    
    
    //
    //For Admin
    //
    
    function loadApplicants(lastid, selection){
    $("#ajaxLoader").show();
    m.getFromDb({
    getAction: "getApps",
    lastId: lastid,
    selection: selection
        }).done(function(resp){
            v.loadApps(resp);
            isWorking = false;
            $("#ajaxLoader").hide();
            if(resp == ""){
                $("#ajaxLoader").remove();
            }
        });
    }
        
    //For CK Editor save function 
    function CKupdate(){
    for ( instance in CKEDITOR.instances )
        CKEDITOR.instances[instance].updateElement();
    }

    
    function adminLoadVacs(){
        v.addNewVacBtn();
        m.getFromDb({
            getAction: "getVacs"
        }).done(function(resp){
            v.adminLoadVacs(resp);
        });
    }
    
    function getVacApps(target){
        m.getFromDb({
            getAction: "getVacApps",
            target: target
        }).done(function(resp){
            v.clearAdminContent();
            v.loadBackToVacsBtn();
            v.loadApps(resp);
        });
    }
    
    function getAllBlogPosts(){
    m.getFromDb({
    getAction: "getAllBlogPosts"
        }).done(function(resp){
            v.adminLoadBlogPosts(resp);
        });
    }
    
    //Load new blog post page
    function newBlogPost(){
        m.getFile("includes/markup/blogpost.html").done(function(resp){
            v.clearAdminContent();
            $(resp).appendTo("#adminContent");
        })
    }
    
    //Load edit blog post page
    function editBlogPost(data){
        m.getFile("includes/markup/editBlogPost.html").done(function(resp){
            v.clearAdminContent();
            $(resp).appendTo("#adminContent");
            v.editBlogView(data); 
        });
    }
    
    //Load new vacancy page
    function newVac(){
        m.getFile("includes/markup/newVac.html").done(function(resp){
            v.clearAdminContent();
            $(resp).appendTo("#adminContent");
        })
    }
    
    //Load edit vacancy page
    function editVac(data){
        m.getFile("includes/markup/editVac.html").done(function(resp){
            v.clearAdminContent();
            $(resp).appendTo("#adminContent");
            v.editVacView(data); 
        });
    }
    
    //Ajax load applicants when nearing bottom of the page
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() > $(document).height() - 200) {
            if(!isWorking && !searchEnabled && appPage){
                isWorking = true;
                var lastId = v.getAppLastId();
                loadApplicants(lastId, 5);
            }
        }
    });
    
    //Search field
    $(document).on("keyup", "#searchForApp", function(){
        var input = $(this).val();
        if(input.trim().length > 2){
            //stops other apps being loaded on scroll
            searchEnabled = true;
            v.removeAjaxLoader();
            m.seachForApp({search: input}).done(function(resp){
               console.log(resp);
                v.loadApps(resp);
            });
        } else if(input.trim().length == 0) {
            $("#adminContent").html("");
            v.clearIdIndex();
            searchEnabled = false;
            loadApplicants(0, 1000);
            v.appendAjaxLoader();
        }
    });
    
    //Show additional content
    $("#adminContent").on("click", ".appMoreDetailsBtn", function(e){
        var target = this;
        var child = $(target).parent().siblings(".appMoreDetails");
        $(child).slideToggle();
    });
    
    //Nav to applicants section
    $("#appsNav").click(function(){
        appPage = true;
        blogPage = false;
        v.adminNavActive(this);
        v.clearAdminContent();
        loadApplicants(0, 15);
        v.loadSearchField();
        v.resetIdIndex();
    });
    
    // Nav to vacancies section
    $("#vacsNav").click(function(){
        appPage = false;
        blogPage = false;
       v.clearAdminContent();
        adminLoadVacs();
        v.adminNavActive(this);
        isWorking = false;
        v.removeAjaxLoader();
    });
    
    //Load applicats relating to specific role
    $("#adminContent").on("click", ".viewAppsFromVacs", function(e){
        //Get id of vacancy
        var target = $(this).parent().parent(".adminVacOverview").attr("id");
            getVacApps(target);
    });
    
    //Go back to to view all vacancies
    $("#adminContent").on("click", ".backToVacsBtn", function(e){
        v.clearAdminContent();
        adminLoadVacs();
    });
    
    //Blog view in admin
    $("#blogNav").click(function(){
        appPage = false;
        blogPage = true;
        v.clearAdminContent();
        v.addNewBlogBtn();
        getAllBlogPosts();
        v.adminNavActive(this);
        isWorking = false;
        v.removeAjaxLoader();
    });
    
    //Add new blog post btn, load new form
    $("#adminSubNav").on("click", ".addNewBlogPostBtn", function(e){
        newBlogPost();
    });
    
    //back to all blog posts
    $("#adminContent").on("click", ".backToBlogPost", function(e){
        v.clearAdminContent();
        v.addNewBlogBtn();
        getAllBlogPosts();
    });
    
    //Submit new blog post
    $(document).on("click", "#submitBlogBtn", function(event){
        CKupdate();
        var formtrue = document.getElementById("updateOrAddBlogPost").checkValidity();
        if(formtrue){
            event.preventDefault();
            var formData = new FormData(document.getElementById("updateOrAddBlogPost"));
            m.submitOrEditBlogForm(formData);
            v.clearAdminContent();
            v.addNewBlogBtn();
            getAllBlogPosts();
            }
    });
    
    //To edit blog post view
    $(document).on("click", ".blogEdit", function(event){
        var target = $(this).parent(".blogOverview").attr("id");
        var data = {getAction: "getSingleBlogPost", id: target};
        m.getFromDb(data).done(function(resp){
            editBlogPost(resp);
        });
    });
    
    //Edit blog post submition
    $(document).on("click", "#editBlogBtn", function(event){
        //For WYISWG editor
        CKupdate();
        var formtrue = document.getElementById("editBlogPost").checkValidity();
        if(formtrue){
            event.preventDefault();
            var formData = new FormData(document.getElementById("editBlogPost"));
            var blogId = $(".blogPostContainer").attr("id");
            formData.append("blogId", blogId);
            m.editBlogPost(formData).done(function(resp){
                v.destroyBlogSuccess();
                v.editBlogSuccess(resp);
            });
        }
        });
    
    //Add new vacancy page
    $("#adminSubNav").on("click", ".addNewVacBtn", function(e){
        newVac();
    });
    
    //Submit new vacancy
    $(document).on("click", "#submitNewVac", function(event){
        CKupdate();
        var formtrue = document.getElementById("addVac").checkValidity();
        if(formtrue){
            event.preventDefault();
            var formData = new FormData(document.getElementById("addVac"));
            m.addVac(formData);
            v.clearAdminContent();
            adminLoadVacs();
        }
    });
    
    //Load vac edit view
    $(document).on("click", ".vacEdit", function(event){
        var target = $(this).parent().parent().attr("id");
        var data = {getAction: "getSingleVac", id: target};
        m.getFromDb(data).done(function(resp){
            editVac(resp);
        });
    });
    
    //Edit vac submit
    $(document).on("click", "#submitEditVac", function(event){
        CKupdate();
        var formtrue = document.getElementById("editVac").checkValidity();
        if(formtrue){
            event.preventDefault();
            var formData = new FormData(document.getElementById("editVac"));
            var vacId = $(".editVacContainer").attr("id");
            formData.append("vacId", vacId);
            m.editVac(formData).done(function(resp){
                v.destroyBlogSuccess();
                v.editBlogSuccess(resp);
            });
        }
    });
    
    // Navigate back to vacancies page
    $("#adminContent").on("click", ".backToVacsAdminBtn", function(e){
        console.log("click");
        v.clearAdminContent();
        adminLoadVacs();
    });
    
    
    //Initial function
    return {
        init: function(){
            controllerLoadCurrentVacs();
            loadBlogPostsPage(0, 5);
            v.loadSearchField();
            $("#adminContent").html("");
            loadApplicants(0, 15);
            v.adminNavActive("#appsNav");
            $("#ajaxLoader").hide();
        }
    }
    
})(model, view);

controller.init();


//////////////
//General JS//
//////////////


//Map for home
function initMap() {
            var uluru = {lat: 52.058061, lng: -0.825188};
            var map = new google.maps.Map(document.getElementById('map'), {
              zoom: 11,
              center: uluru
            });
            var marker = new google.maps.Marker({
              position: uluru,
              map: map
            });
          }



//Scroll to section from home nav
$("#topNav li").click(function(e) {
    
    var appended;
    var target = e.target.innerHTML;
    var lower = target.toLowerCase();
    var noSpace = lower.replace(/\s+/g, '');
    
    //For only certain nav items, ie not for admin, blog or home
    if(noSpace == "about" || noSpace == "benefits" || noSpace == "vacancies" || noSpace == "meettheteam" || noSpace == "currentvacancies"){
    
        e.preventDefault();

        if (noSpace == "currentvacancies"){
            appended = "vacanciesnav";
        } else {
            appended = noSpace + "nav";
        }

        //Set offset to take away so section title in view
        var extraOffset = 0;
        if(appended != "home"){
            extraOffset = 80;
            }
        if(appended == "benefitsnav"){
            extraOffset = 150;
        }
        //Check if full size menu was in use and adjust
        if($(window).scrollTop() <= 50 ){
                extraOffset = 180;
        }

        //animate to position
        $("html, body").animate({
            scrollTop: ($("#" + appended).offset().top - extraOffset)
        }, 500);
        
    }
    
});

//Hero current vacacnies button
$("#heroCurrentVacsBtn").click(function(e) {
    
    $("html, body").animate({
        scrollTop: ($("#" + "vacanciesnav").offset().top - 80)
    }, 500);
    
});

// Add and remove mobile menu class
$(document).on("scroll resize", function(){
    
    var top = $(document).scrollTop();
    var width = $(window).width();
    
    if(top > 50){
        $("#headerNav").addClass("fixed");
        
    } else {
        $("#headerNav").removeClass("fixed");
    }
});

//Change flex direction on menu if resized
$(window).on("resize", function(){
   var width = $(window).width();
    if(width > 983){
        $("#headerNav ul").css("display", "flex");
        $("#headerNav").removeClass("fixed");
    } else {
        $("#headerNav ul").hide();
        $(".mobileNavOverlay").removeClass("showOverlay");
    }
});

//Show menu when mobile nav btn clicked
$("#barsNav").on("click", function(){
   
    if($(".mobileNavOverlay").hasClass("showOverlay")){
        $("#headerNav ul").hide();
        $(".mobileNavOverlay").removeClass("showOverlay");
    } else {
        $("#headerNav ul").slideDown();
        $(".mobileNavOverlay").addClass("showOverlay");
    }
});

//Hide overlay when overlay or link clicked
$(document).on("click", ".mobileNavOverlay, #topNav li", function(){
    var width = $(window).width();
    if(width < 984){
    $(".mobileNavOverlay").removeClass("showOverlay");
    $("#headerNav ul").slideUp();
    }
});






