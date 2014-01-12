
<?php $v = $volunteer["Volunteer"];  ?>

<style>
.dl-horizontal dt {margin-top: 15px; width: 300px;}
.dl-horizontal dd {margin-top: 15px; margin-left: 310px;}
.dl-horizontal dd {font-size: 18px;}
</style>
<small><?php echo $this->Html->link("Edit",
array('controller' => 'Volunteers', 'action' => 'edit', $volunteer['Volunteer']['id']), array("class" => "btn btn-primary pull-right")); ?></small>
<fieldset>
<legend>Volunteer Info </legend>

<dl class="dl-horizontal">
  
    <dt>Volunteer Name</dt> <dd><?php echo $v["firstname"] . " "  . $v["lastname"]; ?></dd> 
  <?php 
    $phones = array();
    if($v["phone1"]){ $phones[] = format_phone($v["phone1"]); }
    if($v["phone2"]){ $phones[] = format_phone($v["phone2"]); }
    if($v["phone3"]){ $phones[] = format_phone($v["phone3"]); }
    ?>

  <?php if($v["phone1"]){ ?>
  	<dt>Cell Phone</dt> <dd><?php echo $v["phone1"]; ?></dd> 
  <?php } ?>
  <?php if($v["phone2"]){ ?>
  	<dt>Home Phone</dt> <dd><?php echo $v["phone2"]; ?></dd> 
  <?php } ?>
  <?php if($v["phone3"]){ ?>
  	<dt>Other Phone</dt> <dd><?php echo $v["phone3"]; ?></dd> 
  <?php } ?>

  <?php if($v["email"]){ ?>
    <dt>Email Address</dt> <dd><?php echo $this->Html->link($v["email"],"mailto:".$v["email"]) ?></dd> 
  <?php } ?>

  <?php if($v["address"]){ ?>
  	<dt>Postal Address</dt> <dd><?php echo $v["address"] ?></dd> 
  <?php } ?>

  <?php if($v["birthday"] || $v["birthmonth"] || $v["birthyear"]){ ?>
    <dt>Birthday</dt> <dd><?php echo format_bday($v["birthday"], $v["birthmonth"], $v["birthyear"]) ?></dd> 
  <?php } ?>


  <?php 
    $langs = array();
    if($v["language1"]){ $langs[] = $v["language1"]; }
    if($v["language2"]){ $langs[] = $v["language2"]; }
    if($v["language3"]){ $langs[] = $v["language3"]; }
    if($v["language4"]){ $langs[] = $v["language4"]; }
    if($v["language5"]){ $langs[] = $v["language5"]; }
    ?>

  <?php if(count($langs) != 0){ ?>
    <dt>Languages</dt> <dd><?php echo join(", ", $langs); ?></dd> 
  <?php } ?>


  <?php 
    $occups = array();
    if($v["occupation"]){ $occups[] = $v["occupation"]; }
    if($v["occupation2"]){ $occups[] = $v["occupation2"]; }
    if($v["occupation3"]){ $occups[] = $v["occupation3"]; }
    if($v["occupationother"]){ $occups[] = $v["occupationother"]; }
    ?>
  <?php if(count($occups) !=0){ ?>
  	<dt>Occupation</dt> <dd><?php echo join(", ", $occups) ?></dd> 
  <?php } ?>
  

  <?php 
    $foundout = array();
    if($v["foundout"]){ $foundout[] = $v["foundout"]; }
    if($v["foundout2"]){ $foundout[] = $v["foundout2"]; }
    if($v["foundout3"]){ $foundout[] = $v["foundout3"]; }
    if($v["foundoutother"]){ $foundout[] = $v["foundoutother"]; }
    ?>
  <?php if(count($foundout) !=0){ ?>
  	<dt>How They Heard Of Us</dt> <dd><?php echo join(", ", $foundout) ?></dd> 
  <?php } ?>
  <?php if($v["orientationdate"] != '0000-00-00' && $v["orientationdate"]){ ?>
    <dt>Orientation Date</dt> <dd><?php echo date_format(date_create($v["orientationdate"]), "F j, Y") ?>
  <?php } ?>


</dl>
</fieldset>


    <?php if($v["emergname"] || $v["emergrelation"] || $v["emergemail"] || $v["emergphone1"] || $v["emergphone2"] || $v["emergphone3"]){ ?>


<?php 
$name = false;
if($v["emergname"] || $v["emergrelation"]) {$name = $v["emergname"]. " (" . $v["emergrelation"] .")";}
else if($v["emergname"]) {$name = $v["emergname"];}
else if($v["emergrelation"]) {$name = $v["emergrelation"];}

?>
<fieldset>
<legend>Emergency Info</legend>


<dl class="dl-horizontal">
  <?php if($name){ ?>
    <dt>Emergency Contact</dt> <dd><?php echo $name ?></dd> 
  <?php } ?>
  <?php 
    $emergphones = array();
    if($v["emergphone1"]){ $emergphones[] = $v["emergphone1"]; }
    if($v["emergphone2"]){ $emergphones[] = $v["emergphone2"]; }
    if($v["emergphone3"]){ $emergphones[] = $v["emergphone3"]; }
    ?>

  <?php if(count($emergphones) != 0){ ?>
    <dt>Emergency Phones</dt> <dd class="bigHover"><?php echo join(" or ", $emergphones); ?></dd> 
  <?php } ?>

  <?php if($v["emergemail"]){ ?>
    <dt>Emergency Email</dt> <dd><?php echo $this->Html->link($v["emergemail"],"mailto:".$v["emergemail"]) ?></dd> 
  <?php } ?>

</dl>
</fieldset>

  <?php } ?>
