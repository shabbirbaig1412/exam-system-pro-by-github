<?php defined('ABSPATH') || exit; ?>

<h1 align="center">

Report Card

</h1>

<table width="100%" border="1" cellspacing="0" cellpadding="6">

<tr>

<td><strong>Name</strong></td>

<td><?=esc_html($student['student_name'])?></td>

</tr>

<tr>

<td><strong>Roll No</strong></td>

<td><?=esc_html($student['roll_no'])?></td>

</tr>

<tr>

<td><strong>Percentage</strong></td>

<td><?=esc_html($student['percentage'])?>%</td>

</tr>

<tr>

<td><strong>Grade</strong></td>

<td><?=esc_html($student['grade'])?></td>

</tr>

<tr>

<td><strong>Status</strong></td>

<td><?=esc_html($student['status'])?></td>

</tr>

</table>