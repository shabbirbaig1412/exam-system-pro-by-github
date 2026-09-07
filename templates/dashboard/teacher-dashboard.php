<?php defined('ABSPATH') || exit; ?>

<div class="esp-dashboard">

<h2>Teacher Dashboard</h2>

<div class="esp-cards">

<div class="esp-card">

<h3>Assigned Classes</h3>

<p><?=count($data['classes'])?></p>

</div>

<div class="esp-card">

<h3>Subjects</h3>

<p><?=count($data['subjects'])?></p>

</div>

<div class="esp-card">

<h3>Pending Marks</h3>

<p><?=$data['pending_marks']?></p>

</div>

</div>

</div>