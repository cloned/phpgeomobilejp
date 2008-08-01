<?php
mb_internal_encoding('UTF-8');
mb_http_output('SJIS-win');

require_once dirname(dirname(__FILE__)) . '/lib/Geomobilejp/Converter.php';
require_once dirname(dirname(__FILE__)) . '/lib/Geomobilejp/IArea.php';
require_once dirname(dirname(__FILE__)) . '/lib/Geomobilejp/Mobile.php';

$url = 'http://' . $_SERVER['SERVER_NAME']
     . preg_replace('/\?.+?$/', '', $_SERVER['REQUEST_URI']);
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS" />
  <title>Geomobilejp_Converter Sample</title>
</head>
<body>
  <div style="font-size:x-small">
    <div style="text-align:center;background-color:#ff9900;">Geomobilejp_Converter Sample</div>
    <br />

<?php

$mobile = new Geomobilejp_Mobile();

if ($mobile->hasParameter()) {

    $converter = new Geomobilejp_Converter(
        $mobile->getLatitude(),
        $mobile->getLongitude(),
        $mobile->getDatum()
    );

    $c1 = $converter->convert('wgs84')->format('dms');
    $c2 = $converter->convert('wgs84')->format('degree');
    $c3 = $converter->convert('tokyo')->format('dms');
    $c4 = $converter->convert('tokyo')->format('degree');

    $area = Geomobilejp_IArea::seekArea($converter);

?>
    parameters<br />
    lat:   <?php echo htmlspecialchars($mobile->getLatitude()) ?><br />
    lon:   <?php echo htmlspecialchars($mobile->getLongitude()) ?><br />
    datum: <?php echo htmlspecialchars($mobile->getDatum()) ?><br />
    <br />
    <hr />

    wgs84(dms)<br />
    lat:   <?php echo htmlspecialchars($c1->getLatitude()) ?><br />
    lon:   <?php echo htmlspecialchars($c1->getLongitude()) ?><br />
    datum: <?php echo htmlspecialchars($c1->getDatum()->getName()) ?><br />
    <br />
    <hr />

    wgs84(degree)<br />
    lat:   <?php echo htmlspecialchars($c2->getLatitude()) ?><br />
    lon:   <?php echo htmlspecialchars($c2->getLongitude()) ?><br />
    datum: <?php echo htmlspecialchars($c2->getDatum()->getName()) ?><br />
    <br />
    <hr />

    tokyo(dms)<br />
    lat:   <?php echo htmlspecialchars($c3->getLatitude()) ?><br />
    lon:   <?php echo htmlspecialchars($c3->getLongitude()) ?><br />
    datum: <?php echo htmlspecialchars($c3->getDatum()->getName()) ?><br />
    <br />
    <hr />

    tokyo(degree)<br />
    lat:   <?php echo htmlspecialchars($c4->getLatitude()) ?><br />
    lon:   <?php echo htmlspecialchars($c4->getLongitude()) ?><br />
    datum: <?php echo htmlspecialchars($c4->getDatum()->getName()) ?><br />
    <br />
    <hr />

    i area<br />
    iarea code: <?php echo htmlspecialchars($area->getIAreaCode()) ?><br />
    iarea name: <?php echo htmlspecialchars($area->getName()) ?><br />
    <br />

    <hr />
    <br />

<?php

}

?>
    docomo<br />
    <form action="sample.php" method="get" lcs="lcs">
      <input type="submit" value="Submit" />
    </form>
    <br />
    <br />

    au (wgs84)<br />
    <form action="device:gpsone" method="get">
      <input type="hidden" name="url" value="<?php echo htmlspecialchars($url) ?>" />
      <input type="hidden" name="datum" value="0" />
      <input type="hidden" name="ver" value="1" />
      <input type="hidden" name="unit" value="0" />
      <input type="hidden" name="acry" value="0" />
      <input type="hidden" name="number" value="0" />
      <input type="submit" value="Submit" />
    </form>
    <br />
    <br />

    au (tokyo)<br />
    <form action="device:gpsone" method="get">
      <input type="hidden" name="url" value="<?php echo htmlspecialchars($url) ?>" />
      <input type="hidden" name="datum" value="1" />
      <input type="hidden" name="ver" value="1" />
      <input type="hidden" name="unit" value="0" />
      <input type="hidden" name="acry" value="0" />
      <input type="hidden" name="number" value="0" />
      <input type="submit" value="Submit" />
    </form>
    <br />
    <br />

    SoftBank<br />
    <a href="location:gps?url=sample.php">Submit</a>
    <br />
    <br />

    WILLCOM<br />
    <a href="http://location.request/dummy.cgi?my=<?php echo htmlspecialchars($url) ?>&pos=$location">Submit</a>
    <br />
    <br />

  </div>
</body>
</html>
