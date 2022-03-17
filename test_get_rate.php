<?php
$payload = file_get_contents('https://www.ecb.europa.eu/stats/policy_and_exchange_rates/euro_reference_exchange_rates/html/eurofxref-graph-chf.en.html');  

preg_match_all("/rateLatest='([0-9.]*)'/", $payload, $out, PREG_PATTERN_ORDER);

$rate=$out[1][0];
preg_match_all("/rateLatestInverse='([0-9.]*)'/", $payload, $out, PREG_PATTERN_ORDER);
$rateInverse=$out[1][0];

echo 'Rate = '.$rate.'<br/>';
echo 'Inverse Rate = '.$rateInverse.'<br/>';

?>
