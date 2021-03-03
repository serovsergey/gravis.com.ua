
<!-- ODNOKLASSNIKI -->
<div id="ok_shareWidget"></div>
<script>
!function (d, id, did, st) {
  var js = d.createElement("script");
  js.src = "http://connect.ok.ru/connect.js";
  js.onload = js.onreadystatechange = function () {
  if (!this.readyState || this.readyState == "loaded" || this.readyState == "complete") {
    if (!this.executed) {
      this.executed = true;
      setTimeout(function () {
        OK.CONNECT.insertShareWidget(id,did,st);
      }, 0);
    }
  }};
  d.documentElement.appendChild(js);
}(document,"ok_shareWidget","<? echo $current_url?>","{width:145,height:30,st:'oval',sz:20,ck:1}");
</script>

<!-- VKONTAKTE -->
<div id="vk_like"></div>
<script type="text/javascript">
VK.Widgets.Like("vk_like", {type: "full", height: 24});
</script>
