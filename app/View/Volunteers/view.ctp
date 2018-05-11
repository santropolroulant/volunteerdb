
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
  <?php $age = (new DateTime($v['birthyear'] . '-' . $v['birthmonth'] . '-' . $v['birthday']))->diff(new DateTime('now'))->y; ?>
    <dt>Birthday</dt> 
    <dd>
      <?php echo format_bday($v["birthday"], $v["birthmonth"], $v["birthyear"]) ?>
      <?php if ($age <= 12) { ?>
      <span class="label label-danger" style="background-color:#d9534f">12 and under</span>
      <?php } else if ($age <= 15) { ?>
      <span class="label label-warning" style="background-color:#f0ad4e">13-15 years old</span>
      <?php } ?>
    </dd>
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

  <?php $mediapermission = $v['mediapermission']; ?>
  <dt>Photo / Video Permission</dt>
  <dd>
    <?php if ($mediapermission) { ?>
    <span class="label label-success">Permission granted</span>
    <?php } else { ?>
    <span class="label label-danger" style="background-color:#d9534f">Permission not granted</span>
    <?php } ?>
  </dd>

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

<?php
$secondContactProps = array('emerg2name', 'emerg2relation', 'emerg2phone1', 'emerg2phone2', 'emerg2phone3', 'emerg2email');
$hasSecondaryContact = false;

$name2 = false;
if($v["emerg2name"] || $v["emerg2relation"]) {$name2 = $v["emerg2name"]. " (" . $v["emerg2relation"] .")";}
else if($v["emerg2name"]) {$name2 = $v["emerg2name"];}
else if($v["emerg2relation"]) {$name2 = $v["emerg2relation"];}

forEach ($secondContactProps as $prop) {
  if ($v[$prop] != '') {
    $hasSecondaryContact = true;
  }
}
?>
<fieldset>
<legend>Emergency Info</legend>

<style type="text/css">
  .alert-secondary {
    color: #555;
    background-color: #eee;
    border-color: #aaa;
  }
</style>

<?php if ($v['emergunable']) { ?>
<div style="margin-bottom: 20px">This volunteer is unable to provide an emergency contact</div>
<?php } else { ?>
<div class="row">
  <div class="span6">
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
  </div>

  <div class="span6">
    <?php if ($hasSecondaryContact) { ?> 
    <dl class="dl-horizontal">
      <?php if($name2){ ?>
        <dt>Emergency Contact</dt> <dd><?php echo $name2 ?></dd> 
      <?php } ?>
      <?php 
        $emerg2phones = array();
        if($v["emerg2phone1"]){ $emerg2phones[] = $v["emerg2phone1"]; }
        if($v["emerg2phone2"]){ $emerg2phones[] = $v["emerg2phone2"]; }
        if($v["emerg2phone3"]){ $emerg2phones[] = $v["emerg2phone3"]; }
        ?>

      <?php if(count($emerg2phones) != 0){ ?>
        <dt>Emergency Phones</dt> <dd class="bigHover"><?php echo join(" or ", $emerg2phones); ?></dd> 
      <?php } ?>

      <?php if($v["emerg2email"]){ ?>
        <dt>Emergency Email</dt> <dd><?php echo $this->Html->link($v["emerg2email"],"mailto:".$v["emerg2email"]) ?></dd> 
      <?php } ?>
    </dl>
    <?php } ?>
  </div>



<?php } ?>
</fieldset>

  <?php } ?>


<fieldset>
  <legend><button id="toggle-notes" class="btn <?php echo $v['notes'] == '' ? 'btn-success' : 'btn-danger' ?>">Notes</button></legend>
  <dl class="dl-horizontal" id="user-notes" style="display:none">
    <?php echo $v['notes'] == '' ? '<i>This volunteer has no notes</i>' : nl2br($v['notes']) ?>
  </dl>
</fieldset>

<script type="text/javascript">
(function () {
  var shown = false;

  function get(selector) {
    return document.getElementById(selector);
  }

  get('toggle-notes').addEventListener('click', function (e) {
    e.preventDefault();
    e.stopPropagation();
    // get('toggle-notes').innerText = shown ? 'Show' : 'Hide';
    get('user-notes').setAttribute('style', shown ? 'display:none' : '');
    shown = !shown;
  });
})();
</script>