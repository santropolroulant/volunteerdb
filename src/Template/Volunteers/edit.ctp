<?php
    echo $this->Form->create($volunteer, [ "id" => "VolunteerEditForm" ]);
    echo $this->Form->hidden('id');
?>

<div class="row">
<div class="span12">
<fieldset>
  <legend>Volunteer Information</legend>

  <div class="row">
    <div class="span4 control-group">
    <?php
      echo $this->Form->label('firstname', 'First Name');
      echo $this->Form->text('firstname', [ "class" => "input-medium" ]);
    ?>
    </div>
    <div class="span4 control-group">
    <?php
      echo $this->Form->label('lastname', 'Last Name');
      echo $this->Form->text('lastname', [ "class" => "input-medium" ]);
    ?>
    </div>
    <div class="span4 control-group">
    <?php
        # Beware: [Form->date()](https://book.cakephp.org/3.0/en/views/helpers/form.html#Cake\View\Helper\FormHelper::date) is *not* the native HTML5 datepicker. Maybe it will be someday but it's not now.
        # Because of that we need to pretend to be type='text' but override that in the options.
        echo $this->Form->label("orientationdate", "Orientation Date");
        echo $this->Form->text("orientationdate", [
              'id' => "orientationdate",
              "type" => "date",
              "class" => "input-medium",
              "value" => $volunteer["orientationdate"] ? $volunteer["orientationdate"]->format("Y-m-d") : NULL,
              "max" => (new DateTime())->format("Y-m-d"), // ensure dates can't be picked in the future
              "min" => "2006-01-01" // this is approximately the date of the first entry in Santropol Roulant's volunteerdb; if you are adapting this for your own organization, please considering pulling this out into a config file somewhere and submitting a patch to make it configurable; I'm just being lazy.
              ]);
    ?>
    </div>
  </div>
  <div class="row">
    <div class="span12 control-group">
    <?php
    echo $this->Form->label('address', "Mailing Address");
    echo $this->Form->textarea('address', [ "style" => "width: 78%" ]);
    ?>
    </div>
  </div>
  <div class="row">
    <div class="span4 control-group">
      <?php
      echo $this->Form->label('phone1', "Cell Phone"); 
      echo $this->Form->tel('phone1', [ "class" => "input-small" ]);
      ?>
    </div>
    <div class="span4 control-group">
      <?php
      echo $this->Form->label('phone2', "Home Phone"); 
      echo $this->Form->tel('phone2', [ "class" => "input-small" ]);
      ?>
    </div>
    <div class='span4 control-group'>
      <?php
      echo $this->Form->label('phone3', "Other Phone"); 
      echo $this->Form->tel('phone3', [ "class" => "input-small" ]);
      ?>
    </div>
  </div>
  <div class="row">
    <div class="span12 control-group">
    <?php
      echo $this->Form->label('email', "Email Address"); 
      echo $this->Form->email('email', [ "class" => "input-small" ]);
    ?>
    </div>
  </div>
</fieldset>
</div>

<style type="text/css">
  .alert-secondary {
    color: #555;
    background-color: #eee;
    border-color: #aaa;
  }

  /* These were recovered from the old bootstrap 2 + cakephp2 settings
     They could probably be redone to make the layout flow better.
   */
  .control-group label {
    /*float: left;*/ /* you can't trust floats! inline-block + controlling margins is better */
    display: inline-block;
    margin-left: 0;
    width: 160px;
    padding-top: 5px;
    text-align: right;
  }

  .control-group input,select,textarea {
    margin-left: 10px;
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
    <div class="span6 control-group">
      <?php
      echo $this->Form->label('emergname', "Contact name"); 
      echo $this->Form->text('emergname');
      ?>
    </div>
    <div class="span6 control-group">
      <?php
      echo $this->Form->label('emergrelation', "Relationship"); 
      echo $this->Form->text('emergrelation');
      ?>
    </div>
    <div class="span6 control-group">
      <?php
      echo $this->Form->label('emergphone1', "Primary Phone");
      echo $this->Form->tel('emergphone1', [ "class" => "input-small" ]);
      ?>
    </div>
    <div class="span6 control-group">
      <?php
      echo $this->Form->label('emergphone2', "Secondary Phone");
      echo $this->Form->tel('emergphone2', [ "class" => "input-small" ]);
      ?>
    </div>
    <div class="span6 control-group">
      <?php
      echo $this->Form->label('emergphone3', "Other Phone");
      echo $this->Form->tel('emergphone3', [ "class" => "input-small" ]);
      ?>
    </div>
    <div class="span6 control-group">
      <?php
      echo $this->Form->label('emergemail', "Email Address");
      echo $this->Form->email('emergemail');
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
    <div class="span6 control-group">
      <?php
      echo $this->Form->label('emerg2name', "Contact Name");
      echo $this->Form->text('emerg2name');
      ?>
    </div>
    <div class="span6 control-group">
      <?php
      echo $this->Form->label('emerg2relation', "Relationship");
      echo $this->Form->text('emerg2relation');
      ?>
    </div>
    <div class="span6 control-group">
      <?php
      echo $this->Form->label('emerg2phone1', "Primary Phone");
      echo $this->Form->tel('emerg2phone1', [ "class" => "input-small" ]);
      ?>
    </div>
    <div class="span6 control-group">
      <?php
      echo $this->Form->label('emerg2phone2', "Secondary Phone");
      echo $this->Form->tel('emerg2phone2', [ "class" => "input-small" ]);
      ?>
    </div>
    <div class="span6 control-group">
      <?php
      echo $this->Form->label('emerg2phone3', "Other Phone");
      echo $this->Form->tel('emerg2phone3', [ "class" => "input-small" ]);
      ?>
    </div>
    <div class="span6 control-group">
      <?php
      echo $this->Form->label('emerg2email', "Email Address");
      echo $this->Form->email('emerg2email');
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
      <div class="checkbox control-group" style="
      padding-top: 15px; padding-bottom: 15px;">
        <?php
        echo $this->Form
                  ->label('emergunable',
                          "I am unable at this time to provide an emergency contact",
                          [ "style" => "width: 400px" ] # Hack: override the default width for labels of 180px
                                                        # in order to fit the entire text on one line
                                                        # This used to not be an issue because pre CakePHP 3.x upgrade
                                                        # this just had the text in a <span>, not a <label>.
                         );
        echo $this->Form->checkbox('emergunable', [ "id" => "emergunable" ]);
        ?>
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
    <div class="control-group">
    <?php
    echo $this->Form->label('birthdate', "Birthdate");
    # Beware: [Form->date()](https://book.cakephp.org/3.0/en/views/helpers/form.html#Cake\View\Helper\FormHelper::date) is *not* the native HTML5 datepicker. Maybe it will be someday but it's not now.
    # Because of that we need to pretend to be type='text' but override that in the options.
    echo $this->Form->text('birthdate', [
          'id' => "birthdate",
          "type" => "date",
          "class" => "input-medium",
          'value' => $volunteer["birthdate"] ? $volunteer["birthdate"]->format("Y-m-d") : NULL,
          "max" => (new DateTime())->modify("-7 years")->format("Y-m-d"),
          "min" => "1926-01-01",
        ]);

        /* Commented out temporarily; will probably be fully removed in favour of the datepicker^ soon.
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
      * /
    echo $this->Form->input('birthyear', array(
      "label" => array("text" => "Birth Year", 'class' => 'control-label'),
      "class" => "input-mini"
    ));

     */
     ?>
     </div>

    <div class="control-group">
    <?php
    echo $this->Form->label('mediapermission', "Photo / Video Permission");
    echo $this->Form->select('mediapermission',
        [
          2 => 'Unanswered',
          0 => "No",
          1 => "Yes"
        ]);
    ?>
    </div>
</div>
<div class="span6 control-group"><!-- XXX this control-group needs to be on individual <div>s if we want the validator to run on these controls -->
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

    echo $this->Form->label('language1', "Primary Language");
    echo $this->Form->select('language1', $languages);
    echo "<br/>\n"; # XXX hack; we should wrap <divs> instead

    echo $this->Form->label('language2', "Secondary Language");
    echo $this->Form->select('language2', $languages);
    echo "<br/>\n"; # XXX hack; we should wrap <divs> instead

    echo $this->Form->label('language3', "Third Language");
    echo $this->Form->select('language3', $languages);
    echo "<br/>\n"; # XXX hack; we should wrap <divs> instead

    echo $this->Form->label('language4', "Fourth Language");
    echo $this->Form->select('language4', $languages);
    echo "<br/>\n"; # XXX hack; we should wrap <divs> instead

    echo $this->Form->label('language5', "Fifth Language");
    echo $this->Form->select('language5', $languages);
    echo "<br/>\n"; # XXX hack; we should wrap <divs> instead

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
      <div class='span12 control-group' id="user-notes" style="display:none">
        <?php
        echo $this->Form->textarea('notes', [ 'style' => 'width: 100%; height: 300px' ]);
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
  echo $this->Form->submit('Save', [ 'class' => 'btn btn-primary btn-large' ]);
?>

<?php
    echo $this->Form->end();
?>


<?php
    if($volunteer) {
        echo $this->Form
                  ->postButton('Delete',
                      [ "controller"=>"Volunteers", "action"=>"edit", $volunteer["id"] ],
                      [ "method" => "delete",
                        "class" => "btn btn-danger pull-right",
                        'onclick'=> "return confirm('Clicking OK will delete. This cannot be undone.')"
                      ]);
    }
?>

<br /><br />

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
        "firstname": {
          minlength: 2,
          required: true
        },
        "lastname": {
          minlength: 2,
          required: true
        },
        //"phone1": {
        //  phoneUS: true
        //},
        //"phone2": {
        //  phoneUS: true
        //},
        //"phone3": {
        //  phoneUS: true
        //},
        //"email": {
        //  email: true
        //},
        "address": {
          minlength: 2
        },
        "emergname": {
          minlength: 2,
        },
        "emergrelation": {
          minlength: 2,
        },
        "emergemail": {
          email: true
        },
        "orientationdate": {
          dateISO: true,
          // *disable* the old half-broken date validator
          // see https://github.com/jquery-validation/jquery-validation/issues/1787
          date: false,
          min: false,
          max: false
        },
        "birthdate": {
          dateISO: true,
          // *disable* the old half-broken date validator
          // see https://github.com/jquery-validation/jquery-validation/issues/1787
          date: false,
          min: false,
          max: false
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
