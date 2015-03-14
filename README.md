2008年8月に作成された国産フィーチャーフォン（ガラケー）の位置情報を扱うためのPHPライブラリです。[pygeomobilejp](https://pypi.python.org/pypi/geomobilejp)を参考にPHP版として作成されました。

現在はメンテナンスされていません。

以下、 docs/Manual.html を読みやすくするためにREADME.mdに転記したものです。

# Geomobilejp_Converter

## 概要

Geomobilejp_Converterはモバイル端末のGPS機能で送信される情報を想定した、緯度経度フォーマット、測地系の相互変換ライブラリです。また、同梱されているGeomobilejp_IAreaを使用すると、緯度経度からオープンiエリアのエリアコードやエリア名を取得することができます。

同梱されているサンプルプログラム、Geomobilejp_Converter/sample/mobile_page_sample.phpにここで説明するコードのすべてが利用されていますので、実装の参考になるでしょう。

PHPのバージョン5で動作します。

## 緯度経度の変換

### Geomobilejp_Converterを生成する

Geomobilejp_Converterクラスを生成します。第1引数に「緯度」、第2引数に「経度」、第3引数に測定した「測地系」を渡します。緯度経度のフォーマットは、度単位（degree）と度分秒単位（dms）に対応しています。

```php
require_once '/path/to/Geomobilejp/Converter.php';

$converter = new Geomobilejp_Converter('35.21.03.340', '138.34.45.725', 'wgs84');
```

### フォーマットを変換する

緯度経度を度単位（degree）と度分秒単位（dms）に相互変換することができます。

```php
require_once '/path/to/Geomobilejp/Converter.php';

$converter = new Geomobilejp_Converter('35.21.03.340', '138.34.45.725', 'wgs84');
$converter = $converter->format('degree');

echo $converter->getLatitude() . "\n";    // 35.350928
echo $converter->getLongitude() . "\n";   // 138.579368
```

### 測地系を変換する

測地系を世界測地系（WGS84）と日本測地系（Tokyo）と日本測地系2000（JGD2000）に相互変換することができます。

```php
require_once '/path/to/Geomobilejp/Converter.php';

$converter = new Geomobilejp_Converter('35.21.03.340', '138.34.45.725', 'wgs84');
$converter = $converter->convert('tokyo');

echo $converter->getLatitude() . "\n";    // 35.20.51.663
echo $converter->getLongitude() . "\n";   // 138.34.56.905
```

### フォーマットと測地系を変換する

フォーマットの変換と測地系の変換は、Geomobilejp_Converterクラスのインスタンスが返ってきますので、相互変換を組み合わせることができます。

```php
require_once '/path/to/Geomobilejp/Converter.php';

$converter = new Geomobilejp_Converter('34.700695', '135.495243', 'wgs84');
$converter = $converter->convert('tokyo')->format('dms');

echo $converter->getLatitude() . "\n";    // 34.41.50.830
echo $converter->getLongitude() . "\n";   // 135.29.53.007
```

## オープンiエリアを取得

### iエリアデータファイルを準備する

docomoの提供するオープンiエリアのエリアコードとエリア名を緯度経度から取得することができます。この機能を利用するためには、まずdocomo サイトで公開されているiエリアデータファイルを取得して次のようにデータファイルを作成してください。尚、PHPの内部エンコーディングはUTF-8であることを想定しています。

```sh
# iエリアデータファイルを取得します。
$ wget http://www.nttdocomo.co.jp/binary/archive/service/imode/make/content/iarea/iareadata.lzh

# iエリアデータファイルを展開します（lhaコマンドがない場合は適宜他の方法で展開してください）。
$ lha e iareadata.lzh

# iエリアデータファイルから1つのPHPデータファイルを作成します。
$ cd ./Geomobilejp_Converter/tools
$ php ./create_iareadata.php ../../iareadata

# 作成されたファイルをGeomobilejp/IAreaディレクトリに移動します。
$ mv ./iareadata.php ../lib/Geomobilejp/IArea/
```

### 緯度経度からiエリアコードとiエリア名を取得する

iエリアデータファイルの準備ができるとGeomobilejp_IAreaを使用して、緯度経度からiエリアコードとiエリア名を取得することができます。

```php
require_once '/path/to/Geomobilejp/Converter.php';
require_once '/path/to/Geomobilejp/IArea.php';

$converter = new Geomobilejp_Converter('34.700695', '135.495243', 'wgs84');
$area = Geomobilejp_IArea::seekArea($converter);

echo $area->getIAreaCode() . "\n";    // 17202
echo $area->getName() . "\n";         // 大阪駅/阪急梅田駅周辺
```

iエリアが見つからなかった場合、Geomobilejp_IArea::seekAreaはnullを返します。

## キャリアの差

### パラメータの差を吸収する

docomo、au、SoftBank、WILLCOMのGPS機能で送信される緯度経度情報は、パラメータ名やフォーマットに違いがあります。User-Agentによる判定を行って、各違いを吸収する必要があります。Geomobilejp_Converterにはこれらの差をパラメータがあるかどうかのみを単純に判定して吸収するGeomobilejp_Mobileが同梱されています。他のUser-Agentを判定するライブラリを使用する場合には不要ですが、役に立つようであればご利用ください。

```php
require_once '/path/to/Geomobilejp/Mobile.php';

$mobile = new Geomobilejp_Mobile();

if ($mobile->hasParameter()) {

    echo $mobile->getLatitude() . "\n";    // N35.44.33.150
    echo $mobile->getLongitude() . "\n";   // E135.22.33.121
    echo $mobile->getDatum() . "\n";       // wgs84

}
```

### HTMLのGPSタグを出し分ける

docomo、au、SoftBank、WILLCOMではそれぞれGPS機能を使用するためのHTML表記がありますが、Geomobilejp_Converterにはこの差を吸収する機能は実装されていません。実際にはGeomobilejp_Converter/sample/mobile_page_sample.phpに表記しているような各キャリア用のHTMLをUser-Agentを判定して出し分ける必要があります。
