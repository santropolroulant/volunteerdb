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
    echo $this->Form->input('orientationdate', array(
      "label" => array("text" => "Orientation Date", 'class' => 'control-label'), 
      'type'=>'text',
      'id' => "orientdationdatepicker",
      "class" => "input-small" 
    ));
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
      "label" => array("text" => "Cell Phone", 'class' => 'control-label'), 
      "class" => "input-small" 
    ));
    echo $this->Form->input('phone2', array(
      "label" => array("text" => "Home Phone", 'class' => 'control-label'), 
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
      "label" => array("text" => "Relationship", 'class' => 'control-label'), 
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
      "Most Common" => array(
        "English" => "English",
        "French" => "French",
        "Italian" => "Italian",
        "Arabic" => "Arabic",
        "Spanish" => "Spanish",
        "Chinese" => "Chinese",
        "Cantonese" => "Cantonese",
        "Mandarin" => "Mandarin",
        "Japanese" => "Japanese",
        "Korean" => "Korean",
        "Creole" => "Creole",
        "Portuguese" => "Portuguese",
        "Romanian" => "Romanian",
        "Vietnamese" => "Vietnamese",
        "Armenian" => "Armenian",
        "Russian" => "Russian",
        "Polish" => "Polish",
      ),
      "Less Common" => array(
        "Albanian" => "Albanian",
        "American Sign Language" => "American Sign Language",
        "Bangla" => "Bangla",
        "Bengali" => "Bengali",
        "Bulgarian" => "Bulgarian",
        "Catalan" => "Catalan",
        "Czech" => "Czech",
        "Danish" => "Danish",
        "Dutch" => "Dutch",
        "Farsi" => "Farsi",
        "Filipino" => "Filipino",
        "German" => "German",
        "Greek" => "Greek",
        "Hebrew" => "Hebrew",
        "Hindi" => "Hindi",
        "Icelandic" => "Icelandic",
        "Khmer" => "Khmer",
        "Ladino" => "Ladino",
        "Latvian" => "Latvian",
        "Lithuanian" => "Lithuanian",
        "Malayalam" => "Malayalam",
        "Mauritian" => "Mauritian",
        "Norwegian" => "Norwegian",
        "Punjabi" => "Punjabi",
        "Serbian" => "Serbian",
        "Swahili" => "Swahili",
        "Swedish" => "Swedish",
        "Tagalog" => "Tagalog",
        "Tamil" => "Tamil",
        "Thai" => "Thai",
        "Turkish" => "Turkish",
        "Ukranian" => "Ukranian",
        "Urdu" => "Urdu",
        "Wolof" => "Wolof",
      )
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
      "label" => array("text" => "Third Language", 'class' => 'control-label'),
      'options' => $languages
      ));
    echo $this->Form->input('language4', array(
      "label" => array("text" => "Fourth Language", 'class' => 'control-label'),
      'options' => $languages
      ));
    echo $this->Form->input('language5', array(
      "label" => array("text" => "Fifth Language", 'class' => 'control-label'),
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
    echo $this->Form->input('occupation2', array(
      "label" => array("text" => "Secondary Occupation", 'class' => 'control-label'),
      'options' => $occupations
    ));
    echo $this->Form->input('occupation3', array(
      "label" => array("text" => "Other Occupation", 'class' => 'control-label'),
      'options' => $occupations
    ));
    echo $this->Form->input('occupationother', array(
      "label" => array("text" => "Occupation Details", 'class' => 'control-label'),
      'type' => 'text',
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
    echo $this->Form->input('foundout2', array(
      "label" => array("text" => "How They Heard Of Us", 'class' => 'control-label'),
      'options' => $foundout
    ));
    echo $this->Form->input('foundout3', array(
      "label" => array("text" => "How They Heard Of Us", 'class' => 'control-label'),
      'options' => $foundout
    ));
    echo $this->Form->input('foundoutother', array(
      "label" => array("text" => "How They Heard Of Us Details", 'class' => 'control-label'),
      'type' => 'text',
    ));



?>
</div>
</fieldset>
</div> <!-- /row -->

<div class="controls">
<?php
	echo $this->Form->button('Save', array('type' => 'submit', 'class' => 'btn btn-primary btn-large'));
?>
</div>

<?php
    echo $this->Form->end();
?>


<?php
    echo $this->Form->create('Volunteer', array(
    	'action' => 'delete',
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
	echo $this->Form->button('Delete', array('type' => 'submit', 'class' => 'btn btn-danger pull-right', 'onclick'=> "return confirm('Clicking OK will delete. This cannot be undone.')"));
    echo $this->Form->end();
?>

<br /><br />

<script>
  
  jQuery.validator.addMethod("phoneUS", function(phone_number, element) {
      phone_number = phone_number.replace(/\s+/g, ""); 
    return this.optional(element) || phone_number.length > 9 &&
      phone_number.match(/^(1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
  }, "Please specify a valid phone number");

    $(function(){
     $("#orientdationdatepicker").datepicker({format:"yyyy-mm-dd", viewMode: "years"});

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
        //"data[Volunteer][phone1]": {
        //  phoneUS: true
        //},
        //"data[Volunteer][phone2]": {
        //  phoneUS: true
        //},
        //"data[Volunteer][phone3]": {
        //  phoneUS: true
        //},
        //"data[Volunteer][email]": {
        //  email: true
        //},
        "data[Volunteer][address]": {
          minlength: 2
        },
        "data[Volunteer][emergname]": {
          minlength: 2,
        },
        "data[Volunteer][emergrelation]": {
          minlength: 2,
        },
        "data[Volunteer][emergemail]": {
          email: true
        },
        "data[Volunteer][birthday]": {
          number: true, min: 1, max: 31
        },
        "data[Volunteer][birthyear]": {
          number: true, min: 1900, max: 2012
        },
        "data[Volunteer][orientationdate]": {
          date: true
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
