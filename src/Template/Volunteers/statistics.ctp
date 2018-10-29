
<!-- # Centered table -->
<style>
table, th, td {
   border: 1px solid black;
   padding: 20px;
   margin: 20px;
}
</style>

<table style="margin: auto">
<?php
  echo $this->Html->tableHeaders(["Count", "Year", "Month"]);
  foreach($monthly_signups as $row) {
    echo $this->Html->tableCells([[$row->count, $row->year, $row->month]]);
  }
?>
</table>
