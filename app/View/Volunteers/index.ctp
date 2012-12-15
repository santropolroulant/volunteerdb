<h2>Recent & Upcoming Birthdays</h2>
<table class="table table-striped">
    <tr>
        <th>Name</th>
        <th>Birthday</th>
    </tr>

    <!-- Here is where we loop through our $volunteers array, printing out volunteer info -->

    <?php foreach ($volunteers as $volunteer): 
        $v = $volunteer['Volunteer'];
        if(abs(delta_days($v["birthday"], $v["birthmonth"])) > 2) continue;
        ?>
    <tr>
        <td>
            <?php echo $this->Html->link($v['firstname'] . " " . $v['lastname'],
array('controller' => 'Volunteers', 'action' => 'view', $v['id'])); ?>
        </td>
        <td>
        <?php if($v["birthday"] || $v["birthmonth"] || $v["birthyear"]){ 
            echo bday_fancy($v["birthday"], $v["birthmonth"], $v["birthyear"]); 
        }?>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php unset($volunteer); ?>
</table>