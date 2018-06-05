<?php
    echo $this->Form->create($volunteer);
    echo $this->Form->input('id', array('type' => 'hidden'));
?>

<div class="row">
<div class="span12">
<fieldset>
  <legend>Volunteer Information</legend>

  <div class="row">
    <div class="span4">
    <?php
      echo $this->Form->input('firstname', array(
        "label" => array("text" => "First Name", 'class' => 'control-label'),
        "class" => "input-medium"  
      ));
    ?>
    </div>
    <div class="span4">
    <?php
      echo $this->Form->input('lastname', array(
        "label" => array("text" => "Last Name", 'class' => 'control-label'), 
        "class" => "input-medium"  
      ));
    ?>
    </div>
    <div class="span4">
    <?php
        echo $this->Form->input('orientationdate', array(
          "label" => array("text" => "Orientation Date", 'class' => 'control-label'), 
          'type'=>'text',
          'id' => "orientdationdatepicker",
          "class" => "input-small" 
        ));
    ?>
    </div>
  </div>
  <div class="row">
    <div class="span12">
    <?php
    echo $this->Form->input('address', array(
      "label" => array("text" => "Mailing Address", 'class' => 'control-label'),
      "style" => "width: 90%"
    ));
    ?>
    </div>
  </div>
  <div class="row">
    <div class="span4">
      <?php
      echo $this->Form->input('phone1', array(
        "label" => array("text" => "Cell Phone", 'class' => 'control-label'), 
        "class" => "input-small" 
      ));
      ?>
    </div>
    <div class="span4">
      <?php
      echo $this->Form->input('phone2', array(
        "label" => array("text" => "Home Phone", 'class' => 'control-label'), 
        "class" => "input-small" 
      ));
      ?>
    </div>
    <div class='span4'>
      <?php
      echo $this->Form->input('phone3', array(
        "label" => array("text" => "Other Phone", 'class' => 'control-label'), 
        "class" => "input-small" 
      ));
      ?>
    </div>
  </div>
  <div class="row">
    <div class="span12">
    <?php
      echo $this->Form->input('email', array(
        "label" => array("text" => "Email Address", 'class' => 'control-label'),
      ));
    ?>    </div>
  </div>
</fieldset>
</div>

<style type="text/css">
  .alert-secondary {
    color: #555;
    background-color: #eee;
    border-color: #aaa;
  }
</style>

  <?php
  # determine if we should show the extra contact fields
  # XXX TODO: this could probably be better done in javascript, since we've got javascript anyway?
  # just set :hidden on the element if it's not there..
  $secondContactProps = array('emerg2name', 'emerg2relation', 'emerg2phone1', 'emerg2phone2', 'emerg2phone3', 'emerg2email');
  $hasSecondaryContact = false;
  forEach ($secondContactProps as $prop) {
    if ($volunteer[$prop] != '') {
      $hasSecondaryContact = true;
    }
  }
  ?>

<div class="span12">
<fieldset >
  <legend>Emergency Contact Information</legend>
  <div class="row">
    <div class="span12" id="primary-header" style="<?php if (!$hasSecondaryContact) echo 'display:none'; ?>">
      <div class="alert alert-secondary">Primary Emergency Contact</div>
    </div>
    <div class="span6">
      <?php
      echo $this->Form->input('emergname', array(
        "label" => array("text" => "Contact Name", 'class' => 'control-label'),
      ));
      ?>
    </div>
    <div class="span6">
      <?php
      echo $this->Form->input('emergrelation', array(
        "label" => array("text" => "Relationship", 'class' => 'control-label'), 
      ));
      ?>
    </div>
    <div class="span6">
      <?php
      echo $this->Form->input('emergphone1', array(
        "label" => array("text" => "Primary Phone", 'class' => 'control-label'), 
        "class" => "input-small" 
      ));
      ?>
    </div>
    <div class="span6">
      <?php
      echo $this->Form->input('emergphone2', array(
        "label" => array("text" => "Secondary Phone", 'class' => 'control-label'),
        "class" => "input-small"  
      ));
      ?>
    </div>
    <div class="span6">
      <?php
      echo $this->Form->input('emergphone3', array(
        "label" => array("text" => "Other Phone", 'class' => 'control-label'),
        "class" => "input-small" 
      ));
      ?>
    </div>
    <div class="span6">
      <?php
      echo $this->Form->input('emergemail', array(
        "label" => array("text" => "Email Address", 'class' => 'control-label'),
      ));
      ?>
    </div>
  </div>

  <div class="row" id="second-emergency-contact-btn-container" style="<?php if ($hasSecondaryContact) echo 'display:none'; ?>">
    <div class="span1"></div>
    <div class="span9">
      <a href="#" id="second-emergency-contact-btn">Add a secondary emergency contact</a>
    </div>
  </div>
  <div class="row" id="second-emergency-contact" style="<?php if (!$hasSecondaryContact) echo 'display:none'; ?>">
    <div class="span12">
      <div class="alert alert-secondary">Secondary Emergency Contact</div>
    </div>
    <div class="span6">
      <?php
      echo $this->Form->input('emerg2name', array(
        "label" => array("text" => "Contact Name", 'class' => 'control-label'),
      ));
      ?>
    </div>
    <div class="span6">
      <?php
      echo $this->Form->input('emerg2relation', array(
        "label" => array("text" => "Relationship", 'class' => 'control-label'), 
      ));
      ?>
    </div>
    <div class="span6">
      <?php
      echo $this->Form->input('emerg2phone1', array(
        "label" => array("text" => "Primary Phone", 'class' => 'control-label'), 
        "class" => "input-small" 
      ));
      ?>
    </div>
    <div class="span6">
      <?php
      echo $this->Form->input('emerg2phone2', array(
        "label" => array("text" => "Secondary Phone", 'class' => 'control-label'),
        "class" => "input-small"  
      ));
      ?>
    </div>
    <div class="span6">
      <?php
      echo $this->Form->input('emerg2phone3', array(
        "label" => array("text" => "Other Phone", 'class' => 'control-label'),
        "class" => "input-small" 
      ));
      ?>
    </div>
    <div class="span6">
      <?php
      echo $this->Form->input('emerg2email', array(
        "label" => array("text" => "Email Address", 'class' => 'control-label'),
      ));
      ?>
    </div>
  </div>
  <script type='text/javascript'>
  (function () {
    function get(id) {
      return document.getElementById(id);
    }

    var contact = get('second-emergency-contact');
    var btnContainer = get('second-emergency-contact-btn-container');
    var btn = get('second-emergency-contact-btn');
    var primary = get('primary-header');

    btn.addEventListener('click', function (e) {
      e.stopPropagation();
      e.preventDefault();
      contact.setAttribute('style', '');
      btnContainer.setAttribute('style', 'display:none');
      primary.setAttribute('style', '');
    });
  })();
  </script>
  <div class="row">
    <div class='span1'></div>
    <div class='span9'>
      <div class="checkbox" style="
      padding-top: 15px; padding-bottom: 15px;">
        <label>
        <?php
        echo $this->Form->checkbox('emergunable', array(
          "label" => array("text" => "I am unable at this time to provide an emergency contact", 'class' => 'control-label'),
          "id" => "emergunable"
        ));
        ?>
        <span style="margin-left: 15px">I am unable at this time to provide an emergency contact</span>
        </label>
      </div>
    </div>
  </div>
</fieldset>
</div>
</div> <!-- /row -->

<div class="row">
  <div class="span12">
<fieldset >
  <legend>Optional Information</legend>

<div class="row"> 
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
    echo $this->Form->select('birthmonth', $months, [
        "empty" => ""
        ]);
        
        /* array(
      "label" => array("text" => "Birth Month", 'class' => 'control-label'),
      'options' => $months, "empty" => ""
      ));
      */
    echo $this->Form->input('birthyear', array(
      "label" => array("text" => "Birth Year", 'class' => 'control-label'),
      "class" => "input-mini"
    ));

    echo $this->Form->input('mediapermission',
       array(
        'label' => array("text" => 'Photo / Video Permission', 'class' => 'control-label'),
        'type' => 'select',
        'options' => array(
          2 => 'Unanswered',
          0 => "No",
          1 => "Yes"
        )
      ));
?>
</div>
<div class="span6">
<?php

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
</div>
</fieldset>
</div>
</div> <!-- /row -->

<?php $notes = $volunteer['notes']; ?>
<div class="row" style="margin-bottom: 20px">
  <div class='span12'>
    <fieldset >
      <legend><button id="toggle-notes" class="btn <?php echo $notes == '' ? 'btn-success' : 'btn-danger' ?>">Notes</button></legend>
      <div class='span12' id="user-notes" style="display:none">
        <?php
        echo $this->Form->textarea('notes', array(
          'style' => 'width: 100%; height: 300px'
        ));
        ?>
      </div>
    </fieldset>
  </div>
</div>

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

<?php
  echo $this->Form->button('Save', array('type' => 'submit', 'class' => 'btn btn-primary btn-large'));
?>

<?php
    echo $this->Form->end();
?>


<?php
    echo $this->Form->create($volunteer,
                [ "method" => "post",
                  "url" => \Cake\Routing\Router::url(['controller' => 'Volunteers', 'action' => 'delete'])
                ]);
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
