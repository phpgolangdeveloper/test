<?php

ob_start();

echo 123;
$res = ob_get_contents();
ob_end_clean();
echo $res;

echo phpinfo();