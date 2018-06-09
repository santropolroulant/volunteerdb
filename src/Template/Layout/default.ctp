
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $this->fetch('title'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <?php echo $this->Html->css([
        'bootstrap',
        'datepicker'
        ]); ?>
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>

    <?php echo $this->Html->script([
        'jquery-1.8.3.min.js',
        'jquery.validate.min.js',
        'bootstrap.min.js',
        'bootstrap-datepicker.js',
        'jquery.placeholder.min.js'
        ]); ?>
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <?php echo $this->Html->link("Volunteers", ["controller"=>"Volunteers", "action"=>"index"], ["class"=>"brand"]); ?>
          <div class="nav-collapse collapse">
            <!-- TODO: update this <form> using $this->Form ? -->
            <form class="navbar-search pull-right" action="<?php echo $this->Url->build(["controller"=>"Volunteers","action"=>"search"]); ?>" method="GET" id="searchform">
              <input type="text" class="search-query" id='searchbox' placeholder="Search..." name="term" value="<?php echo defined("search_term") ? htmlspecialchars($search_term) : "" ?>"  autocomplete="off">
            </form>
            <ul class="nav">
              <li class="active"><?php echo $this->Html->link("Add a Volunteer", ["controller"=>"Volunteers","action"=>"edit"]); ?></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">

			<?php echo $this->Flash->render(); ?>

			<?php echo $this->fetch('content'); ?>


    </div> <!-- /container -->
    <script>
    $(function(){
      $('input[placeholder]').placeholder();
      $("#searchbox").typeahead({
        source: function (query, process) {
          $.get('<?php echo $this->Url->build(["controller" => "Volunteers", "action" => "search.json"]) ?>',
                { term: query },
                function(data) {
                  /* bootstrap-typeahead wants a simple list of strings:
                     http://bootstrapdocs.com/v2.1.1/docs/javascript.html#typeahead
                     but the API returns database tuples.

                     TODO: newer versions of this plugin have displayText
                           to handle doing this map()
                           https://github.com/bassjobsen/Bootstrap-3-Typeahead
                   */
                  process(data.map((volunteer) => { return volunteer.firstname + " " + volunteer.lastname }));
                });
        },
        /* when an item is chosen from the list, jump to it */
        updater: function(item) {
          $('#searchbox').val(item);
          $('#searchform').submit();
          return item;
        }
      });
    });
    </script>
  </body>
</html>


