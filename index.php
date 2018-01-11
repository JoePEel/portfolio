<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Joe Peel - Web Developer</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
      <link href="https://fonts.googleapis.com/css?family=Open+Sans|Raleway:400,700" rel="stylesheet">
      <link rel="stylesheet" href="CSS/portfolio.css" type="text/css">
      <link rel="stylesheet" href="fontAwesome/css/font-awesome.min.css">
  </head>
  <body data-spy="scroll" data-target="#navbar-example" data-offset="250">
      
<!--Nav and Hero image-->     
      
<div id="overlay">      
<div class="heroHome" id="home">
    <div class="container">
        <div class="row topNav">
            <h3 class="title">JOE PEEL</h3>
            <i class='fa fa-bars fa-2x' id="mobileIcon" aria-hidden='true'></i>
            <ul class="listNav">
                <a href="#home"><li>Home</li></a>
                <a href="#about"><li>About</li></a>
                <a href="#portfolio"><li>Portfolio</li></a>
            </ul>
            
        </div>
        <div id="mainHeading">
        <h1>Wannabe Web Developer;</h1>
            <h4>In Milton Keynes. Self taught. Motivated. Eager to learn.</h4>
        </div>
    </div>
</div> 
</div>
      
      
      
<!--Side Nav-->      
      
      
<ul class="nav justify-content-end" id="navbar-example">
  <li class="nav-item">
    <a class="nav-link active" href="#home">HOME</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#about">ABOUT</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#portfolio">PORTFOLIO</a>
  </li>
</ul>      
      

<!--About-->
      
<div class="container section" id="about">
    <h1 class="pinkHeading">ABOUT</h1>
    <div class="row">
        <div class="col-md-6">
            <p>Hi I'm Joe Peel. I've been working in recruitment for the past several years. I'm now looking to switch careers and become a web developer. I've been using online resources such as Udemy, Treehouse, Stack Overflow and w3schools to get a grasp of several web technologies.</p>
            <i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i><p id="cv" class="contact"><a href="JoePeelCV2018.pdf" download>My CV</a></p>
            <br>
            <i class="fa fa-mobile fa-2x" aria-hidden="true"></i><p id="phone" class="contact"><a href="tel:07507948566"S>07507 948 566</a></p>
            <br>
            <i class="fa fa-envelope-open fa-2x" aria-hidden="true"></i><p class="contact"><a href="mailto:joe.peel@live.com">joe.peel@live.com</a></p>
            <br>
            <i class="fa fa-linkedin-square fa-2x" aria-hidden="true"></i><p id="linkedin" class="contact"><a href="https://uk.linkedin.com/in/joepeelpytec">LinkedIn</a></p>
        </div>
        <div id="techSkills" class="col-md-6">
            <p><span class="bold">So far, I've worked with:</span></p>
            <ul>
                <li>HTML and CSS (plus SASS)</li>
                <li>Bootstrap 4</li>
                <li>JavaScript (parts of ES6, learning more!), jQuery, AJAX and Vue.js (inc Vuex and Vue Router)</li>
                <li>PHP and MySQL</li>
                <li>Firebase Realtime Database</li>
                <p class="mt-4">Over the next few weeks I'm going to create a Github account, see what I can push / contribute and continue with my online courses.</p>
            </ul>

        </div>
    </div>
</div>      
      
      
 <!--Portfolio-->     
      
<div class="container section" id="portfolio">
    <h1 class="pinkHeading">PORTFOLIO</h1>
    
    <div class="row portfolioItemRow" id="gymSite">
            <div class="col-lg-6" id="portfolioImgContainer">

               <h1 class="comingSoon">Coming Soon!</h1>
           
            </div>
        <div class="col-lg-6">
            <p>My eccomerce site / SPA <strong>(work in progress)</strong> will be a result of gaining a better understanding of some of Vue.js's more advance features, like:</p>
            <ul>
                <li>Single file templates</li>
                <li>Vuex for state management</li>
                <li>Vue Router</li>
                <li>Vue CLI / Webpack</li>
            </ul>
        </div>
    </div>  
    
    
    <div class="row portfolioItemRow" id="gymSite">
            <div class="col-lg-6 push-lg-6" id="portfolioImgContainer">
            <div id="portfolioImg">
                <a href="gymSite/index.html">
            <img src="img/gym.jpg" id="atsImage" class="theImage">
                <div class="overlay">
                <div class="overlayText"><h4>View</h4></div>
                </div>
                </a>
                </div>
            </div>
        <div class="col-lg-6 pull-lg-6">
            <p>With my gym home page I've utilised a better SASS structure by organising my code across multiple files. This has made locating anything I need to change easier and writing media queries more straightforward.</p>
        </div>
    </div>  
        
    
    <div class="row portfolioItemRow" id="ats2">
            <div class="col-lg-6" id="portfolioImgContainer">
            <div id="portfolioImg">
                <a href="ats2/index.html">
            <img src="img/ats2.jpg"  class="theImage">
                <div class="overlay">
                <div class="overlayText"><h4>View</h4></div>
                </div>
                </a>
                </div>
            </div>
        <div class="col-lg-6">
            <p>Carrying on the recruitment theme from earlier, I've built a second applicant tracking system that offers a better user experience. It's given me chance to better understand:</p>
            <ul>
                <li>Vue.js</li>
                <li>Vuetify (A frontend framework for use with Vue)</li>
                <li>Google's Firebase Realtime Database</li>
            </ul>
        </div>
    </div>        
    
    
    <div class="row portfolioItemRow" id="careersPage">
        <div class="col-lg-6  push-lg-6" id="portfolioImgContainer">
            <div id="portfolioImg">
                <a href="golfClub/index.html">
            <img src="img/golfClubImage.jpg" id="careersPageImage" class="theImage">
                <div class="overlay">
                <div class="overlayText"><h4>View</h4></div>
                </div>
                </a>
                </div>
            </div>
        <div class="col-lg-6 pull-lg-6">
            <p>Golf Club homepage - This has given me some CSS practise, I used a jQuery plugin and built a couple of basic elements like the course guide and "book tee times" section.</p>
        </div>
    </div>         
    
        <div class="row portfolioItemRow" id="careersPage">
            <div class="col-lg-6" id="portfolioImgContainer">
            <div id="portfolioImg">
                <a href="careersPage/index.php">
            <img src="img/careersImage.jpg" id="careersPageImage" class="theImage">
                <div class="overlay">
                <div class="overlayText"><h4>View</h4></div>
                </div>
                </a>
                </div>
            </div>
        <div class="col-lg-6">
            <p>My Careers page<span class="bold"> (Do check out the "Admin" section!)</span> has helped me improve and better understand:</p>
            <ul>
                <li>AJAX -  For searching, loading on scroll, building a part SPA and form submissions</li>
                <li>Javascript - I've tried to implement a basic module / MVC pattern</li>
                <li>JSON</li>
                <li>SASS</li>
                <li>SQL Joins</li>
            </ul>
        </div>
    </div>   
        
    
    
    <div class="row portfolioItemRow" id="ats">
        <div class="col-lg-6 push-lg-6" id="portfolioImgContainer">
            <div id="portfolioImg">
                <a href="ats/ats.php">
                <img src="img/atsImage.jpg" id="atsImage" class="theImage">
                <div class="overlay">
                <div class="overlayText"><h4>View</h4></div>
                </div>
                </a>
            </div>
        </div>
        <div class="col-lg-6 pull-lg-6">
            <p>This is my PHP CRUD project. It's helped me better understand and practise:</p>
            <ul>
                <li>PDO</li>
                <li>MySQL</li>
                <li>Sessions</li>
            </ul>
            <br>
            <p><strong>You can log in with the username "test" and password "test123".</strong></p>
        </div>
    </div>
     
    <div class="row portfolioItemRow" id="draggable">
        <div class="col-lg-6" id="portfolioImgContainer">
            <div id="portfolioImg">
                <a href="draggable/index.html">
                <img src="img/draggable.jpg" class="theImage">
                <div class="overlay">
                <div class="overlayText"><h4>View</h4></div>
                </div>
                </a>
            </div>
        </div>
        <div class="col-lg-6">
            <p>Check out my not so challenging quiz that utilises jQuery and jQuery UI.</p>
        </div>
    </div>
      
</div>
<!--End of portfolio container-->
      
      
<div class="footer">
    <p>&copy <?php echo date("Y"); ?> Joe Peel.</p>
</div>
      
      
<script
  src="https://code.jquery.com/jquery-3.2.1.js"
  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
  crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <script src="portfolio.js"></script>
  </body>
</html>