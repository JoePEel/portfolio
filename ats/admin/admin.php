<?php
$pageTitle = "Dashboard"; 
require("includes/headernav.php");
?>

<div class="col-md-10" id="main-content">
    <div class="row">
        <div class="col-md-6">
            
            <?php
            // Count cadidate source for google table
            $reedCount = countCVSource("Reed");
            $websiteCount = countCVSource("Website");
            $linkedinCount = countCVSource("LinkedIn");
            $refferalCount = countCVSource("Refferal");
            $agencyCount = countCVSource("Agency");
            ?>

   
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Source', 'Number'],
          ['Reed',<?php echo $reedCount; ?>],
          ['Website',<?php echo $websiteCount; ?>],
          ['LinkedIn',<?php echo $linkedinCount; ?>],
          ['Refferal',<?php echo $refferalCount; ?>],
          ['Agency',<?php echo  $agencyCount; ?>]
        ]);

        var options = {
          title: 'CV Sources'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>

    <div id="piechart"></div>
</div>
        
        
        
         <div class="col-md-6">
            <?php
            // Count candidates added in current month
            $currentMonthFull = date("F");
            
            //Candidates added
            $sql = "SELECT candidate_date FROM candidates";
            $target = "candidate_date";
            $candidatesAdded =  dateAddedCount($sql, $target);
            
            $sql = "SELECT vacancy_date FROM vacancies";
            $target = "vacancy_date";
            $vacacniesAdded =  dateAddedCount($sql, $target);
            
            $sql = "SELECT prospect_date FROM prospects WHERE prospect_status > 1";
            $target = "prospect_date";
            $CvsSent =  dateAddedCount($sql, $target);
            
            ?>

 <script type="text/javascript">
     
    var newCan = <?php echo $candidatesAdded; ?>;
    var newVac = <?php echo $vacacniesAdded; ?>;
     var cvs = <?php echo $CvsSent; ?>;
     
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['<?php echo $currentMonthFull; ?>', 'Added'],
          ['New CVs', newCan],
          ['Vacancies', newVac],
          ['CVs sent', cvs]
        ]);

        var options = {
          chart: {
            title: 'Added in <?php echo $currentMonthFull; ?>',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>

    <div id="columnchart"></div>
            
        </div>
        <!--End of bar chart div-->
    </div>
    <!--End of inner row-->
</div>
<!--End of main content div-->

</div>
<!--End of page row-->
<?php
require("includes/footer.php");
?>
