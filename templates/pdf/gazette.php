<?php defined('ABSPATH') || exit; ?>

<h2 align="center">

Gazette Sheet

</h2>

<table width="100%" border="1" cellspacing="0" cellpadding="4">

<tr>

<th>Roll</th>

<th>Name</th>

<th>Obtained</th>

<th>%</th>

<th>Grade</th>

<th>Position</th>

</tr>

<?php foreach($students as $student): ?>

<tr>

<td><?=$student['roll_no']?></td>

<td><?=$student['student_name']?></td>

<td><?=$student['obtained']?></td>

<td><?=$student['percentage']?></td>

<td><?=$student['grade']?></td>

<td><?=$student['position']?></td>

</tr>

<?php endforeach; ?>

</table>