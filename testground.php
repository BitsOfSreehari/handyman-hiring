<?php
$rating = 3;
var_dump($rating);
$whole_part = (int) $rating;
var_dump($whole_part);
$decimal_part = $rating - $whole_part;
var_dump($decimal_part);
while ($whole_part > 0) {
    echo '<svg width="25" height="23" viewBox="0 0 25 23" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12.5 0.993445L16.1089 7.18966L16.2198 7.38005L16.4352 7.42668L23.4434 8.94428L18.6656 14.2913L18.5188 14.4556L18.541 14.6749L19.2634 21.809L12.7016 18.9175L12.5 18.8286L12.2984 18.9175L5.7366 21.809L6.45892 14.6749L6.48112 14.4556L6.33431 14.2913L1.5566 8.94428L8.56478 7.42668L8.78012 7.38005L8.89101 7.18966L12.5 0.993445Z" fill="#FFCC18" stroke="#1E201E"/>
          </svg>';
    $whole_part--;
}
if ($decimal_part <= 0.5 && $decimal_part != 0) {
    echo '<svg width="13" height="23" viewBox="0 0 13 23" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M8.56476 7.42668L8.7801 7.38005L8.891 7.18966L12 1.85189V19.0489L5.73658 21.809L6.4589 14.6749L6.4811 14.4556L6.33429 14.2913L1.55658 8.94428L8.56476 7.42668Z" fill="#FFCC18" stroke="#1E201E"/>
          </svg>';
} elseif ($decimal_part > 0.5) {
    echo '<svg width="25" height="23" viewBox="0 0 25 23" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12.5 0.993445L16.1089 7.18966L16.2198 7.38005L16.4352 7.42668L23.4434 8.94428L18.6656 14.2913L18.5188 14.4556L18.541 14.6749L19.2634 21.809L12.7016 18.9175L12.5 18.8286L12.2984 18.9175L5.7366 21.809L6.45892 14.6749L6.48112 14.4556L6.33431 14.2913L1.5566 8.94428L8.56478 7.42668L8.78012 7.38005L8.89101 7.18966L12.5 0.993445Z" fill="#FFCC18" stroke="#1E201E"/>
          </svg>';
}