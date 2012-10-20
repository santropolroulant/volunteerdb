
<?php 
$v = $volunteer["Volunteer"]; 

function format_phone($phone)
{
	$phone = preg_replace("/[^0-9]/", "", $phone);

	if(strlen($phone) == 10)
		return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "$1-$2-$3", $phone);
	else
		return $phone;
}

function format_bday($day, $month, $year) {

$months = array(
      1 => "January",
      2 => "February",
      3 => "March",
      4 => "April",
      5 => "May",
      6 => "June",
      7 => "July",
      8 => "August",
      9 => "September",
      10 => "October",
      11 => "November",
      12 => "December"
      );

  if($month) {
    $result = "";
    $result .= $months[$month];
    if($day) $result .= " $day";
    if($year) $result .= ", $year";
    return $result;
  }
  else if($year) return $year;
  return "";
}

function bday_fancy($day, $month, $year)
{
  
}

?>

<fieldset>
<legend><?php echo $v["firstname"] . " "  . $v["lastname"]?>  <small><?php echo $this->Html->link("Edit",
array('controller' => 'Volunteers', 'action' => 'edit', $volunteer['Volunteer']['id']), array("class" => "btn btn-primary pull-right")); ?></small></legend>

<style>
.dl-horizontal dt {margin-top: 8px; width: 300px;}
.dl-horizontal dd {margin-top: 8px; margin-left: 310px;}
</style>

<dl class="dl-horizontal">
  
  <?php if($v["email"]){ ?>
  	<dt>Email</dt> <dd><?php echo $this->Html->link($v["email"],"mailto:".$v["email"]) ?></dd> 
  <?php } ?>
  <?php if($v["phone1"]){ ?>
  	<dt>Primary Phone</dt> <dd><?php echo format_phone($v["phone1"]) ?></dd> 
  <?php } ?>
  <?php if($v["phone2"]){ ?>
  	<dt>Secondary Phone</dt> <dd><?php echo format_phone($v["phone2"]) ?></dd> 
  <?php } ?>
  <?php if($v["phone3"]){ ?>
  	<dt>Other Phone</dt> <dd><?php echo format_phone($v["phone2"]) ?></dd> 
  <?php } ?>
  <?php if($v["address"]){ ?>
  	<dt>Address</dt> <dd><?php echo $v["address"] ?></dd> 
  <?php } ?>

  <?php if($v["birthday"] || $v["birthmonth"] || $v["birthyear"]){ ?>
    <dt>Birthday</dt> <dd><?php echo format_bday($v["birthday"], $v["birthmonth"], $v["birthyear"]) ?></dd> 
  <?php } ?>

  <?php if($v["emergname"]){ ?>
  	<dt>Emergency Contact</dt> <dd><?php echo $v["emergname"] ?></dd> 
  <?php } ?>
  <?php if($v["emergrelation"]){ ?>
  	<dt>Relationship</dt> <dd><?php echo $v["emergrelation"] ?></dd> 
  <?php } ?>
  <?php if($v["emergemail"]){ ?>
  	<dt>Emergency Email</dt> <dd><?php echo $this->Html->link($v["emergemail"],"mailto:".$v["emergemail"]) ?></dd> 
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


  <?php if($v["language1"]){ ?>
  	<dt>Primary Language</dt> <dd><?php echo $v["language1"] ?></dd> 
  <?php } ?>
  <?php if($v["language2"]){ ?>
  	<dt>Secondary Language</dt> <dd><?php echo $v["language2"] ?></dd> 
  <?php } ?>
  <?php if($v["language3"]){ ?>
  	<dt>Other Language</dt> <dd><?php echo $v["language3"] ?></dd> 
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

</dl>
</fieldset>