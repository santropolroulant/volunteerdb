
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $title_for_layout; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="<?php echo $this->webroot ?>css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="<?php echo $this->webroot ?>js/jquery.validate.min.js"></script>
    <script src="<?php echo $this->webroot ?>js/bootstrap.min.js"></script>
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
          <a class="brand" href="<?php echo $this->webroot ?>Volunteers">Volunteers</a>
          <div class="nav-collapse collapse">
            <form class="navbar-search pull-right" action="<?php echo $this->webroot ?>Volunteers/jump" method="GET">
              <input type="text" class="search-query" id='searchbox' name="term" placeholder="Search..."  autocomplete="off">
            </form>
            <ul class="nav">
              <li class="active"><a href="<?php echo $this->webroot ?>Volunteers/edit">Add a Volunteer</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>


    </div> <!-- /container -->
    <script>
    $(function(){
      $("#searchbox").typeahead({
        matcher: function(){return true;},
        source: function (query, process) {
          return $.get('<?php echo $this->webroot ?>Volunteers/search.json', { term: query }, process);
        }
      });
    });
    </script>
  </body>
</html>


