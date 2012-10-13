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
	?>
<fieldset>
  <legend>Volunteer Information</legend>

<?php
    echo $this->Form->input('firstname');
    echo $this->Form->input('lastname');
    echo $this->Form->input('id', array('type' => 'hidden'));

?>
</fieldset>

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
        /*phone1: {
          required: true,
          phoneUS: true
        },
        phone2: {
          required: true,
          phoneUS: true
        },
        email: {
          required: true,
          email: true
        },
        address: {
          minlength: 2,
          required: true
        },
        emergname: {
          minlength: 2,
          required: true
        },
        emergrelation: {
          minlength: 2,
          required: true
        },
        emergphone1: {
          required: true,
          phoneUS: true
        },
        emergphone2: {
          required: true,
          phoneUS: true
        },*/
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