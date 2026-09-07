<?php defined('ABSPATH') || exit; ?>

<div class="esp-card">

<h2>Recent Exams</h2>

<table class="widefat striped">

<thead>

<tr>

<th>Exam</th>

<th>Class</th>

<th>Date</th>

</tr>

</thead>

<tbody>

<?php foreach($recent_exams as $exam): ?>

<tr>

<td><?=$exam->exam_name?></td>

<td><?=$exam->class_name?></td>

<td><?=$exam->exam_date?></td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>