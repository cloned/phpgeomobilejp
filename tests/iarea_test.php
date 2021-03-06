<?php
require dirname(dirname(__FILE__)) . '/lib/Geomobilejp/Converter.php';
require dirname(dirname(__FILE__)) . '/lib/Geomobilejp/IArea.php';

$cases = array(
    array('26.229683', '127.687912', 'wgs84', '24900', '那覇/浦添'),
    array('31.610703', '130.562897', 'wgs84', '24400', '鹿児島'),
    array('32.814978', '129.865265', 'wgs84', '23100', '長崎'),
    array('33.273426', '130.297165', 'wgs84', '22600', '佐賀/鳥栖'),
    array('34.096454', '134.547501', 'wgs84', '21100', '徳島市'),
    array('33.955037', '130.923042', 'wgs84', '20502', '下関'),
    array('35.545636', '134.208984', 'wgs84', '18600', '鳥取'),
    array('34.292396', '132.591248', 'wgs84', '20003', '呉/江田島'),
    array('34.700695', '135.495243', 'wgs84', '17202', '大阪駅/阪急梅田駅周辺'),
    array('34.987675', '135.757713', 'wgs84', '14900', '京都駅周辺'),
    array('34.256649', '135.181274', 'wgs84', '15900', '和歌山/海南'),
    array('35.135633', '135.892639', 'wgs84', '14100', '大津市'),
    array('36.582728', '136.647778', 'wgs84', '13102', '金沢駅/武蔵/東山'),
    array('35.413956', '136.756439', 'wgs84', '12400', '岐阜'),
    array('34.976142', '138.388767', 'wgs84', '09900', '静岡駅周辺'),
    array('35.699791', '139.774203', 'wgs84', '05702', '秋葉原'),
    array('35.683584', '139.766092', 'wgs84', '05700', '東京駅周辺'),
    array('35.645168', '139.723348', 'wgs84', '05905', '広尾/白金'),
    array('35.705053', '139.579840', 'wgs84', '06800', '吉祥寺/三鷹'),
    array('38.317956', '140.883179', 'wgs84', '01900', '仙台市周辺'),
    array('40.836931', '140.734520', 'wgs84', '01100', '青森'),
    array('41.777841', '140.726452', 'wgs84', '00100', '函館/渡島'),
    array('43.067790', '141.351814', 'wgs84', '00206', '札幌駅周辺'),
    array('42.994352', '144.382324', 'wgs84', '00600', '釧路'),
);

foreach ($cases as $case) {
    $converter = new Geomobilejp_Converter($case[0], $case[1], $case[2]);
    $area = Geomobilejp_IArea::seekArea($converter);
    assert($area->getIAreaCode() === $case[3]);
    assert($area->getName() === $case[4]);
}
