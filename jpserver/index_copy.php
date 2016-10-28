<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"/>
  <title>宅配希望時間ヒートマップ</title>

  <!-- 外部ファイルのインポート -->
  <link rel="stylesheet" href="index.style.css">
  <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyB-DChcRioj2lMlZk0hj0-SbnrEeKfYVp8&sensor=FALSE&libraries=visualization"></script>

</head>


<body onload="initialize()"> <!--文書全体の読み込みが終了次第、属性onloadの属性値oinitialize()が実行される-->
  <div id="map_canvas" style="width:100%; height:94.8%"></div>
  <input type="range" min="0" max="86400" value="0" step="3600" onchange="showValue(this.value)"/> <!-- スライダを作成する,onchange属性は値が変更されたときに実行 -->
  <span id="range">0:00</span> <!-- spanは特定の処理をさせる意味なしタグ -->
  <script type="text/javascript">
    var map;
    function initialize() {
      var address = prompt("好きな住所を入力してください。\n今のところ空白で送信したら大丈夫！\n                                                       by Yamashita Keisuke")
      var address = "新御茶ノ水";
      var geocoder = new google.maps.Geocoder();
      geocoder.geocode( {'address':address}, function(results, status) {
      // ジオコーディングが成功した場合
      if (status == google.maps.GeocoderStatus.OK) {
        // google.maps.Map()コンストラクタに定義されているsetCenter()メソッドで
        map.setCenter(results[0].geometry.location);
        // 変換した緯度・経度情報を渡してインスタンスを生成
        var marker = new google.maps.Marker({
          map: map,
          animation: google.maps.Animation.DROP,
          position: results[0].geometry.location
        });
      } else {alert(address + 'の住所情報を取得することができませんでした: ' + status);}
    });

      // 地図の作成
      map = new google.maps.Map(document.getElementById('map_canvas'), { // google.maps.Map(第一引数(表示位置,サイズ)のdiv要素（ここではid指定した),第二引数(オプション))
        zoom: 14, 								// 地図のズームを指定
        streetViewControl:false, 	//ストリートビュー無効化
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        mapTypeControl: false,
      });

  }
    // スライダーを表示、値を取得
    function showValue(newValue){
      var minute = ":00";
      var time_hour = newValue / 3600;
      initialize();
      if(newValue==86400){
        time_hour -= 1;
        minute = ":59";
      }else{}
        document.getElementById("range").innerHTML=time_hour+minute;
    }
  </script>
</body>
</html>
