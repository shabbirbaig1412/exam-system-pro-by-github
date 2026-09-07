<?php defined('ABSPATH') || exit; ?>

<div class="wrap">

<h1>Marks Entry</h1>

<div class="esp-card">

<form method="get">

<input type="hidden" name="page" value="esp-marks">

<select name="exam_id">

<?php foreach($exams as $exam): ?>

<option value="<?=$exam->id?>">

<?=$exam->exam_name?>

</option>

<?php endforeach; ?>

</select>

<select name="subject_id">

<?php foreach($subjects as $subject): ?>

<option value="<?=$subject->id?>">

<?=$subject->subject_name?>

</option>

<?php endforeach; ?>

</select>

<button class="button button-primary">

Load Students

</button>

</form>

</div>

<?php if(!empty($students)): ?>

<div class="esp-card">

<form class="esp-ajax-form">

<input type="hidden"

name="action"

value="esp_save_marks">

<?php wp_nonce_field('esp_nonce', 'nonce'); ?>

<table class="widefat striped">

<thead>

<tr>

<th>Roll</th>

<th>Name</th>

<th width="120">

Marks

</th>

</tr>

</thead>

<tbody>

<?php foreach($students as $student): ?>

<tr>

<td><?=$student->roll_no?></td>

<td><?=$student->student_name?></td>

<td>

<input

type="number"

step="0.01"

name="marks[<?=$student->id?>]"

value="<?=$student->obtained_marks?>"

class="small-text esp-mark-input">

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

<br>

<button class="button button-primary">

Save All Marks

</button>

</form>

</div>

<?php endif; ?>

</div>
