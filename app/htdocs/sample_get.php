<?php
echo "通信方式は" . $_SERVER['REQUEST_METHOD'] . "です". "<br>";
echo "test_para1は" .  $_GET['test_para1'] . "です" . "<br>";
echo "test_param2は" . $_GET["test_param2"] . "です";
//http://localhost/sample_get.php?test_para1=aaa&test_param2=bbb