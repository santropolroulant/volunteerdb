<h1>Volunteers</h1>
<table class="table table-striped">
    <tr>
        <th>Name</th>
        <th>Orientation Date</th>
    </tr>

    <!-- Here is where we loop through our $volunteers array, printing out volunteer info -->
    <?php foreach ($volunteers as $volunteer): ?>
    <tr>
        <td>
            <?php echo $this->Html->link($volunteer['firstname'] . " " . $volunteer['lastname'],
array('controller' => 'Volunteers', 'action' => 'view', $volunteer['id'])); ?>
        </td>
        <td><?php echo $volunteer['orientationdate']; ?></td>
    </tr>
    <?php endforeach; ?>
    <?php unset($volunteer); ?>

</table>

    <div id="nav">
    <style>
    #nav {
      /* floats are evil but oh well */
      margin-right: 0;
      margin-left: 70%;
    }
    #nav li {
      display: inline-block;
      margin: .3em;

      border:1px solid #CCC;
      background: #f9f9f9;
      box-shadow: 0 0 5px -1px rgba(0,0,0,0.2);
      cursor:pointer;
      vertical-align:middle;
      padding: 5px;
      text-align: center;
    }
    </style>

    <label>Pages:</label>
    <?php
      echo $this->Paginator->first();
    ?>
    <?php
      echo $this->Paginator->prev();
    ?>

    <?php
      echo $this->Paginator->current();
    ?>
    of
    <?php
      echo $this->Paginator->total();
    ?>

    <?php
      echo $this->Paginator->next();
    ?>
    <?php
      echo $this->Paginator->last();
    ?>
    </div>
