<?php
// Example Ads API (ads.php)
header('Content-Type: application/json');

$ads = [
    [
        "id" => 1,
        "image_url" => "https://media1.tenor.com/m/ezc5dhBOlfEAAAAC/acceleracers-acceleracer.gif",
        "link" => "https://example.com/product1",
        "animation_type" => "slide"
    ],
    [
        "id" => 2,
        "image_url" => "https://media1.tenor.com/m/RFF4c1K_o1QAAAAC/oscar-mayer-food.gif",
        "link" => "https://example.com/product2",
        "animation_type" => "bounce"
    ],
    [
        "id" => 3,
        "image_url" => "https://media1.tenor.com/m/oy9UhKto6G0AAAAd/acceleracers-vert.gif",
        "link" => "https://example.com/product3",
        "animation_type" => "fade"
    ],
];

echo json_encode($ads);
?>
