<?php
    echo $this->Form->create('Volunteer', array(
    	'action' => 'edit',
    	'class' => 'form-horizontal',
		'inputDefaults' => array(
		    'div' => 'control-group',
		    'label' => array('class' => 'control-label'),
		    'between' => '<div class="controls">',
		    'after' => '</div>',
		    'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-error'))
		)
	));

  echo $this->Form->input('id', array('type' => 'hidden'));
	?>

<div class="row">
<div class="span6">
<fieldset>
  <legend>Volunteer Information</legend>

<?php
    echo $this->Form->input('firstname', array(
      "label" => array("text" => "First Name", 'class' => 'control-label'),
      "class" => "input-medium"  
    ));
    echo $this->Form->input('lastname', array(
      "label" => array("text" => "Last Name", 'class' => 'control-label'), 
      "class" => "input-medium"  
    ));
    echo $this->Form->input('email', array(
      "label" => array("text" => "Email Address", 'class' => 'control-label'),
    ));
    echo $this->Form->input('phone1', array(
      "label" => array("text" => "Primary Phone", 'class' => 'control-label'), 
      "class" => "input-small" 
    ));
    echo $this->Form->input('phone2', array(
      "label" => array("text" => "Secondary Phone", 'class' => 'control-label'), 
      "class" => "input-small" 
    ));
    echo $this->Form->input('phone3', array(
      "label" => array("text" => "Other Phone", 'class' => 'control-label'), 
      "class" => "input-small" 
    ));
    echo $this->Form->input('address', array(
      "label" => array("text" => "Mailing Address", 'class' => 'control-label'), 
    ));
?>
</fieldset>
</div>

<div class="span6">
<fieldset >
  <legend>Emergency Contact Information</legend>

<?php
    echo $this->Form->input('emergname', array(
      "label" => array("text" => "Contact Name", 'class' => 'control-label'),
    ));
    echo $this->Form->input('emergrelation', array(
      "label" => array("text" => "Relationship to Volunteer", 'class' => 'control-label'), 
    ));
    echo $this->Form->input('emergphone1', array(
      "label" => array("text" => "Primary Phone", 'class' => 'control-label'), 
      "class" => "input-small" 
    ));
    echo $this->Form->input('emergphone2', array(
      "label" => array("text" => "Secondary Phone", 'class' => 'control-label'),
      "class" => "input-small"  
    ));
    echo $this->Form->input('emergphone3', array(
      "label" => array("text" => "Other Phone", 'class' => 'control-label'),
      "class" => "input-small" 
    ));
    echo $this->Form->input('emergemail', array(
      "label" => array("text" => "Email Address", 'class' => 'control-label'),
    ));
?>
</fieldset>
</div>
</div> <!-- /row -->

<div class="row">
<fieldset >
  <legend>Optional Information</legend>

<div class="span6">
<?php
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

    echo $this->Form->input('birthday', array(
      "label" => array("text" => "Birth Day", 'class' => 'control-label'),
      "class" => "input-mini"
    ));
    echo $this->Form->input('birthmonth', array(
      "label" => array("text" => "Birth Month", 'class' => 'control-label'),
      'options' => $months, "empty" => ""
      ));
    echo $this->Form->input('birthyear', array(
      "label" => array("text" => "Birth Year", 'class' => 'control-label'),
      "class" => "input-mini"
    ));

    $languages = array( "",
"French" => "French", 
"English" => "English", 
"Italian" => "Italian", 
"Arabic" => "Arabic", 
"Spanish" =>"Spanish", 
"Creole" => "Creole",  
"Chinese" => "Chinese",
"Greek" => "Greek",
"Portuguese" => "Portuguese",
"Romanian" => "Romanian",
"Vietnamese" => "Vietnamese",
"Russian" => "Russian",
"Armenian" => "Armenian",
"Polish" => "Polish"
      );
    echo $this->Form->input('language1', array(
      "label" => array("text" => "Primary Language", 'class' => 'control-label'),
      'options' => $languages
      ));
    echo $this->Form->input('language2', array(
      "label" => array("text" => "Secondary Language", 'class' => 'control-label'),
      'options' => $languages
      ));
    echo $this->Form->input('language3', array(
      "label" => array("text" => "Other Language", 'class' => 'control-label'),
      'options' => $languages
      ));
?>
</div>
<div class="span6">
<?php
    $occupations = array(
      "" => "", 
      "Student" => "Student", 
      "Working" => "Working", 
      "Seeking Work" => "Seeking Work", 
      "Caregiver" => "Caregiver", 
      "Retired" => "Retired", 
      "Visiting/Vacation" => "Visiting/Vacation",
      "Other" => "Other"
      );
    echo $this->Form->input('occupation', array(
      "label" => array("text" => "Primary Occupation", 'class' => 'control-label'),
      'options' => $occupations
    ));
    echo $this->Form->input('occupationother', array(
      "label" => array("text" => "Occupation Details/Other", 'class' => 'control-label'),
    ));

    $foundout = array(
      ""=> "", 
      "Neighbourhood/Santropol Cafe"=> "Neighbourhood/Santropol Cafe", 
      "School"=> "School", 
      "Work"=> "Work", 
      "Media"=> "Media", 
      "Internet"=> "Internet", 
      "Roulant Event"=>"Roulant Event",
      "Volunteer Bureau of Montreal"=> "Volunteer Bureau of Montreal", 
      "Friend/Word of Mouth"=> "Friend/Word of Mouth", 
      "Other" => "Other"
      );
    echo $this->Form->input('foundout', array(
      "label" => array("text" => "How They Heard Of Us", 'class' => 'control-label'),
      'options' => $foundout
    ));
    echo $this->Form->input('foundoutother', array(
      "label" => array("text" => "How They Heard Of Us Details/Other", 'class' => 'control-label'),
    ));



?>
</div>
</fieldset>
</div> <!-- /row -->

<div class="controls">
<?php
	echo $this->Form->button('Save', array('type' => 'submit', 'class' => 'btn btn-primary btn-large'));
	echo " ";
	echo $this->Form->button('Reset', array('type' => 'reset', 'class' => 'btn'));
?>
</div>

<?php
    echo $this->Form->end();
?>




<script>

  jQuery.validator.addMethod("phoneUS", function(phone_number, element) {
      phone_number = phone_number.replace(/\s+/g, ""); 
    return this.optional(element) || phone_number.length > 9 &&
      phone_number.match(/^(1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
  }, "Please specify a valid phone number");

    $(function(){
 
     $('#VolunteerEditForm').validate(
     {
      rules: {
        "data[Volunteer][firstname]": {
          minlength: 2,
          required: true
        },
        "data[Volunteer][lastname]": {
          minlength: 2,
          required: true
        },
        "data[Volunteer][phone1]": {
          phoneUS: true
        },
        "data[Volunteer][phone2]": {
          phoneUS: true
        },
        "data[Volunteer][phone3]": {
          phoneUS: true
        },
        "data[Volunteer][email]": {
          email: true
        },
        "data[Volunteer][address]": {
          minlength: 2
        },
        "data[Volunteer][emergname]": {
          minlength: 2,
        },
        "data[Volunteer][emergrelation]": {
          minlength: 2,
        },
        "data[Volunteer][emergphone1]": {
          phoneUS: true
        },
        "data[Volunteer][emergphone2]": {
          phoneUS: true
        },
        "data[Volunteer][emergphone3]": {
          phoneUS: true
        },
        "data[Volunteer][emergemail]": {
          email: true
        },
      },
      errorClass: "help-inline",
      highlight: function(label) {
        $(label).closest('.control-group').removeClass("success").addClass('error');
      },
      success: function(label) {
        label.text("OK!").closest('.control-group').removeClass("error").addClass('success');
      }
     });
    }); // end document.ready
    </script>