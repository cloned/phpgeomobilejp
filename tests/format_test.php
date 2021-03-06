<?php
require dirname(dirname(__FILE__)) . '/lib/Geomobilejp/Converter.php';

$cases = array(
    array('35.39.24.00',   '139.40.15.054',  'degree', '35.656667',     '139.670848'),
    array('35.34.24.218',  '139.37.09.379',  'degree', '35.573394',     '139.619272'),
    array('-35.34.24.218', '-139.37.09.379', 'degree', '-35.573394',    '-139.619272'),
    array('N35.34.24.218', 'E139.37.09.379', 'degree', '35.573394',     '139.619272'),
    array('N35.34.24.218', 'W139.37.09.379', 'degree', '35.573394',     '-139.619272'),
    array('S35.34.24.218', 'E139.37.09.379', 'degree', '-35.573394',    '139.619272'),
    array('S35.34.24.218', 'W139.37.09.379', 'degree', '-35.573394',    '-139.619272'),
    array('n35.34.24.218', 'e139.37.09.379', 'degree', '35.573394',     '139.619272'),
    array('n35.34.24.218', 'w139.37.09.379', 'degree', '35.573394',     '-139.619272'),
    array('s35.34.24.218', 'e139.37.09.379', 'degree', '-35.573394',    '139.619272'),
    array('s35.34.24.218', 'w139.37.09.379', 'degree', '-35.573394',    '-139.619272'),
    array('35.000',        '139.000',        'degree', '35',            '139'),
    array('35.573394',     '139.619272',     'dms',    '35.34.24.218',  '139.37.09.379'),
    array('-35.573394',    '-139.619272',    'dms',    '-35.34.24.218', '-139.37.09.379'),
    array('N35.573394',    'W139.619272',    'dms',    '35.34.24.218',  '-139.37.09.379'),
    array('n35.573394',    'w139.619272',    'dms',    '35.34.24.218',  '-139.37.09.379'),
    array('S35.573394',    'E139.619272',    'dms',    '-35.34.24.218', '139.37.09.379'),
    array('s35.573394',    'e139.619272',    'dms',    '-35.34.24.218', '139.37.09.379'),
    array('35.0.0.0',      '139.0.0.0',      'dms',    '35.00.00.000',  '139.00.00.000'),
);

foreach ($cases as $case) {
    $converter = new Geomobilejp_Converter($case[0], $case[1], 'wgs84');
    assert($converter->format($case[2])->getLatitude() === $case[3]);
    assert($converter->format($case[2])->getLongitude() === $case[4]);
}
