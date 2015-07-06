<?php

pm_Context::init('panel-news');

$taskId = pm_Settings::get('periodic_task_id');
$task = pm_Scheduler::getInstance()->getTaskById($taskId);
pm_Scheduler::getInstance()->removeTask($task);
