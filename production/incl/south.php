 </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
       <?php include 'incl/footer.php';?>
        <!-- /footer content -->
      </div>
    </div>
	<?php include 'incl/script.php';?>
  <?php
    if($link == "dashboard"){
      include 'script/dashboard.php'; 
    }else if($link == "crop"){
      include 'script/crop.php'; 
    }else if($link == "activity"){
      include 'script/activity.php'; 
    }else if($link == "cropType"){
      include 'script/cropType.php'; 
    }else if($link == "growingSeason"){
      include 'script/growingSeason.php'; 
    }else if($link == "wateringNeeds"){
      include 'script/wateringNeeds.php'; 
    }else if($link == "plantingTechnique"){
      include 'script/plantingTechnique.php'; 
    }else if($link == "profile"){
      include 'script/profile.php'; 
    }
  ?>
  </body>
</html>