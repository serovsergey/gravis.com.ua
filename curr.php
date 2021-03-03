<?
$usd_json = file_get_contents('currency/usd.json', FILE_USE_INCLUDE_PATH);
$usd_data = json_decode($usd_json);
$usd_ask = $usd_data->currencies["0"]->rates["0"]->ask;
$usd_bid = $usd_data->currencies["0"]->rates["0"]->bid;
$usd_kurs = ($usd_ask + $usd_bid) / 2;
?>