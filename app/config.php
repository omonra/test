<?

header("Content-Type: application/x-javascript");
$config = array(
    "appmap" => array(
        "main" => "/app/",
        "left" => "/app/left.php",
        "settings" => "/app/settings.php",
        "hash" => substr($hash, rand(1, strlen($hash)))
    )
);
echo json_encode($config);
