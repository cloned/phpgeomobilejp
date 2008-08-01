<?php
require dirname(dirname(__FILE__)) . '/lib/Geomobilejp/Converter.php';

$cases = array(
    array('35.65580',    '139.65580'),
    array('35.39.24.00', '139.40.15.05'),
);

foreach ($cases as $case) {
    $converter = new Geomobilejp_Converter($case[0], $case[1], 'wgs84');
    assert($converter->getLatitude() === $case[0]);
    assert($converter->getLongitude() === $case[1]);
    assert($converter->getPoint()->getLatitude() === $case[0]);
    assert($converter->getPoint()->getLongitude() === $case[1]);
}
