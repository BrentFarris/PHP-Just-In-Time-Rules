<?php

require_once(__DIR__.'/JITR/JITR.php');
require_once(__DIR__.'/JITR/Interpreter.php');
require_once(__DIR__.'/JITR/Components/Component.php');

$jitr = new \JITR\JITR();

$outSize = 4;
$useSize = 4;

/*
$script = '#first=3;#second=6;#third=0;#same=false;\\JITR\\Components\\Math\\Add;use(#first,#second);out[#third];
\\JITR\\Components\\Math\\Subtract;use(#third,#first,#first);out[#third];
\\JITR\\Components\\Math\\Equals;use(#first,#third);out[#same];';
*/

/*
$script = '#first=3;#second=6;#third=0;#same=false;
\\JITR\\Components\\Math\\Equals;use(#first,#second);out[#same];run{
\\JITR\\Components\\Math\\Add;use(#first,#second);out[#third];|
\\JITR\\Components\\Math\\Subtract;use(#third,#first,#first);out[#third];}';
*/

/*
$script = '#test=5;\\JITR\\Components\\Debug\\Log;use(#test);';
*/

/*
$script = '#first=3;#second=6;#third=0;#greater=false;
\\JITR\\Components\\Math\\GreaterThan;use(#first,#second);out[#greater];run{
\\JITR\\Components\\Debug\\Log;use(#first);|
\\JITR\\Components\\Debug\\Log;use(#second);}';
*/

$script = '#minimum=50;#current=$coins;#success=false;#good="good";#bad="bad";
\\JITR\\Components\\Math\\LessThan;use(#minimum,#current);out[#success];run{
\\JITR\\Components\\Debug\\Log;use(#good);|
\\JITR\\Components\\Debug\\Log;use(#bad);}';

$interpreter = $jitr->run($script);