
<?php $v = $volunteer["Volunteer"];  ?>

<style>
.dl-horizontal dt {margin-top: 15px; width: 300px;}
.dl-horizontal dd {margin-top: 15px; margin-left: 310px;}
.dl-horizontal dd {font-size: 18px;}
</style>

<fieldset>
<legend><?php echo $v["firstname"] . " "  . $v["lastname"]?>  <small><?php echo $this->Html->link("Edit",
array('controller' => 'Volunteers', 'action' => 'edit', $volunteer['Volunteer']['id']), array("class" => "btn btn-primary pull-right")); ?></small></legend>


<dl class="dl-horizontal">
  
  <?php if($v["email"]){ ?>
  	<dt>Email Address</dt> <dd><?php echo $this->Html->link($v["email"],"mailto:".$v["email"]) ?></dd> 
  <?php } ?>
  <?php 
    $phones = array();
    if($v["phone1"]){ $phones[] = format_phone($v["phone1"]); }
    if($v["phone2"]){ $phones[] = format_phone($v["phone2"]); }
    if($v["phone3"]){ $phones[] = format_phone($v["phone3"]); }
    ?>

  <?php if(count($phones != 0)){ ?>
  	<dt>Phone Numbers</dt> <dd><?php echo join(" or ", $phones); ?></dd> 
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

  <?php if(count($langs != 0)){ ?>
    <dt>Languages</dt> <dd><?php echo join(", ", $langs); ?></dd> 
  <?php } ?>


  <?php if($v["occupation"]){ ?>
  	<dt>Occupation</dt> <dd><?php echo $v["occupation"] ?></dd> 
  <?php } ?>
  <?php if($v["occupationother"]){ ?>
  	<dt>Occupation Details/Other</dt> <dd><?php echo $v["occupationother"] ?></dd> 
  <?php } ?>
  <?php if($v["foundout"]){ ?>
  	<dt>How They Heard Of Us</dt> <dd><?php echo $v["foundout"] ?></dd> 
  <?php } ?>
  <?php if($v["foundoutother"]){ ?>
  	<dt>How They Heard Of Us Details/Other</dt> <dd><?php echo $v["foundoutother"] ?></dd> 
  <?php } ?>

    <dt>Record Created</dt> <dd><?php echo date_format(date_create($v["created"]), "F j, Y"); ?></dd> 
  <?php if($v["created"] != $v["modified"]){ ?> 
    <dt>Record Modified</dt> <dd><?php echo date_format(date_create($v["modified"]), "F j, Y") ?></dd> 
  <?php } ?>

</dl>
</fieldset>


    <?php if($v["emergname"] || $v["emergrelation"] || $v["emergemail"] || $v["emergphone1"] || $v["emergphone2"] || $v["emergphone3"]){ ?>

<fieldset>
<legend>Emergency Contact</legend>


<dl class="dl-horizontal">
    <?php if($v["emergname"]){ ?>
    <dt>Emergency Contact</dt> <dd><?php echo $v["emergname"] ?></dd> 
  <?php } ?>
  <?php if($v["emergrelation"]){ ?>
    <dt>Relationship</dt> <dd><?php echo $v["emergrelation"] ?></dd> 
  <?php } ?>
  <?php if($v["emergphone1"]){ ?>
    <dt>Primary Emergency Phone</dt> <dd><?php echo format_phone($v["emergphone1"]) ?></dd> 
  <?php } ?>
  <?php if($v["emergphone2"]){ ?>
    <dt>Secondary Emergency Phone</dt> <dd><?php echo format_phone($v["emergphone2"]) ?></dd> 
  <?php } ?>
  <?php if($v["emergphone3"]){ ?>
    <dt>Other Emergency Phone</dt> <dd><?php echo format_phone($v["emergphone2"]) ?></dd> 
  <?php } ?>
  <?php if($v["emergemail"]){ ?>
    <dt>Emergency Email</dt> <dd><?php echo $this->Html->link($v["emergemail"],"mailto:".$v["emergemail"]) ?></dd> 
  <?php } ?>

</dl>
</fieldset>

  <?php } ?>