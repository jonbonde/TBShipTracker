<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
</head>

<body>
    <?php
    $mmsi = "259322000"; //Polarlys, Hurtigruten
    $ua = "";

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://id.barentswatch.no/connect/token',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'client_id=&client_secret=&scope=ais&grant_type=client_credentials',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded',
            $ua
        ),
    ));

    $response = curl_exec($curl);
    curl_reset($curl);
    curl_close($curl);

    $json = json_decode($response, true);
    $token = $json['access_token'];
    //echo $token;




    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://historic.ais.barentswatch.no/open/v1/historic/trackslast24hours/$mmsi",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            "Authorization: bearer $token",
            $ua
        ),
    ));

    $response = curl_exec($curl);
    curl_reset($curl);
    curl_close($curl);
    $json = json_decode($response, true);

    $name = $json[0]['name'];
    $longditude = $json[0]['longditude'];
    $latitude = $json[0]['latitude'];
    var_dump($response);
    echo "Navn: $name\nLengdegrad: $longditude\nBreddegrad: $latitude";
    ?>
</body>

</html>