<?php
require dirname(dirname(__FILE__)) . '/lib/Geomobilejp/Converter.php';

$cases = array(
    array('35.20.51.664',    '138.34.56.905',    'tokyo', 'wgs84', '35.21.03.340',    '138.34.45.725'),
    array('35.20.39.984328', '138.35.08.086122', 'tokyo', 'wgs84', '35.20.51.663',    '138.34.56.903'),
    array('35.39.36.145',    '139.39.58.871',    'wgs84', 'tokyo', '35.39.24.489',    '139.40.10.430'),
    array('35.656666980678', '139.67084801907',  'wgs84', 'tokyo', '35.653429047834', '139.67405883191'),
);

foreach ($cases as $case) {
    $converter = new Geomobilejp_Converter($case[0], $case[1], $case[2]);
    assert($converter->convert($case[3])->getLatitude() === $case[4]);
    assert($converter->convert($case[3])->getLongitude() === $case[5]);
}
