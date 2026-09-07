<?php defined('ABSPATH') || exit; ?>

<h2 align="center">

Tabulation Sheet

</h2>

<table width="100%" border="1" cellspacing="0" cellpadding="3">

<thead>

<tr>

<th>Roll</th>

<th>Name</th>

<th>Total</th>

<th>Obtained</th>

<th>%</th>

<th>Status</th>

</tr>

</thead>

<tbody>

<?php foreach($rows as $row): ?>

<tr>

<td><?=$row['roll_no']?></td>

<td><?=$row['student_name']?></td>

<td><?=$row['total']?></td>

<td><?=$row['obtained']?></td>

<td><?=$row['percentage']?></td>

<td><?=$row['status']?></td>

</tr>

<?php endforeach; ?>

</tbody>

</table>