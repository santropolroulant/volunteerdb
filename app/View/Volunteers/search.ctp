<h1>Volunteers</h1>
<table class="table table-striped">
    <tr>
        <th>#</th>
        <th>Name</th>
    </tr>

    <!-- Here is where we loop through our $volunteers array, printing out volunteer info -->

    <?php foreach ($volunteers as $volunteer): ?>
    <tr>
        <td><?php echo $volunteer['Volunteer']['id']; ?></td>
        <td>
            <?php echo $this->Html->link($volunteer['Volunteer']['firstname'] . " " . $volunteer['Volunteer']['lastname'],
array('controller' => 'Volunteers', 'action' => 'view', $volunteer['Volunteer']['id'])); ?>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php unset($volunteer); ?>
</table>