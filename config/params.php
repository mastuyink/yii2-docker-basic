<?php
$paramsLocal  = json_decode(getenv('PARAMS_LOCAL'),true);
$paramsGlobal = [
];
return array_merge($paramsGlobal,$paramsLocal);