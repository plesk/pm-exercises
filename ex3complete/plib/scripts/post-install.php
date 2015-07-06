<?php

pm_Context::init('panel-stats');

pm_Settings::set('useAuth', true);
pm_Settings::set('authToken', md5(uniqid(rand(), true)));

