
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $this->fetch('title'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="<?php echo $this->request->getAttribute("webroot") ?>css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo $this->request->getAttribute("webroot") ?>css/datepicker.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <script src="<?php echo $this->request->getAttribute("webroot") ?>js/jquery-1.8.3.min.js"></script>
    <script src="<?php echo $this->request->getAttribute("webroot") ?>js/jquery.validate.min.js"></script>
    <script src="<?php echo $this->request->getAttribute("webroot") ?>js/bootstrap.min.js"></script>
    <script src="<?php echo $this->request->getAttribute("webroot") ?>js/bootstrap-datepicker.js"></script>
    <script src="<?php echo $this->request->getAttribute("webroot") ?>js/jquery.placeholder.min.js"></script>
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
          <a class="brand" href="<?php echo $this->request->getAttribute("webroot") ?>Volunteers">Volunteers</a>
          <div class="nav-collapse collapse">
            <form class="navbar-search pull-right" action="<?php echo $this->request->getAttribute("webroot") ?>Volunteers/jump" method="GET" id="searchform">
              <input type="text" class="search-query" id='searchbox' placeholder="Search..." name="term" value="<?php echo defined("search_term") ? htmlspecialchars($search_term) : "" ?>"  autocomplete="off">
            </form>
            <ul class="nav">
              <li class="active"><a href="<?php echo $this->request->getAttribute("webroot") ?>Volunteers/edit">Add a Volunteer</a></li>
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
        items: 20,
        matcher: function(){return true;},
        source: function (query, process) {
          $.get('<?php echo $this->request->getAttribute("webroot") ?>Volunteers/search.json',
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


