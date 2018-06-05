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