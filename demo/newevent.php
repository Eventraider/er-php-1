<?php

namespace Eventraider\demo;
use Eventraider;

define ('ER_SDK_DIR', __DIR__.'/../' );

require_once(ER_SDK_DIR.'EventraiderSession.php');
require_once(ER_SDK_DIR.'EventraiderRequest.php');
require_once(ER_SDK_DIR.'EventraiderResponse.php');
require_once(ER_SDK_DIR.'EventraiderException.php');
require_once(ER_SDK_DIR.'EventraiderLocation.php');

?>

<!DOCUMENT html>
<html>
<head>
    <title>API Demo</title>
    <meta charset="utf-8">
</head>
<body>
<?php

//Sollte das Input File nicht den namen "image_file" haben, muss der name angepasst werden
//$_FILES['image_file'] = $_FILES['filename'];

if (isset($_FILES['image_file'])) {


    try {

        $session = new \Eventraider\EventraiderSession('APP_KEY', 'APP_SECRET');

    } catch (\Eventraider\EventraiderException $e) {

        echo 'Fehler: '.$e->getMessage()."\n";

    }

    if (isset($session)) {

        $request = new \Eventraider\EventraiderRequest($session, '/me/location', 'GET', array('ID' => -1));
        try {

            $response = $request->execute();

        } catch (\Eventraider\EventraiderException $e) {

            echo 'Fehler: '.$e->getMessage()."\n";
            unset($_FILES['image_file']);
            echo '<a href="javascript:window.location.href=window.location.href">zurück</a>';
            exit();

        }
        $location = $response->getLocationObject();

        if ($location->getID() < 0) {

            echo "Fatal error: Es wurde noch kein Standort gesetzt. \n
            Melde dich mit deinem Konto an und stelle unter \"Einstellungen > Marker\" deinen Standort ein.";

        }

        $date = $_POST['year'].'-'.$_POST['month'].'-'.$_POST['day'];

        $event = array(
            'date' => $date,
            'name' => $_POST['title'],
            'timeStart' => $_POST['open'],
            'timeEnd' => $_POST['close'],
            'locationID' => $location->getID(),
            'image' => $_FILES['image_file'],
            'description' => $_POST['description'],
            'license' => null
        );

        $request = new \Eventraider\EventraiderRequest($session, '/event', 'POST', $event);
        try {

            $response = $request->execute();

        } catch (\Eventraider\EventraiderException $e) {

            echo 'Fehler: '.$e->getMessage()."\n";
            unset($_FILES['image_file']);
            echo '<a href="javascript:window.location.href=window.location.href">zurück</a>';
            exit();

        }

        echo $response->getData()."\n";

    } else {

        echo "Session konnte nicht initialisiert werden.\n";

    }

    unset($_FILES['image_file']);
    echo '<a href="javascript:window.location.href=window.location.href">zurück</a>';

} else {

    ?>

    <form method="post" enctype="multipart/form-data">

        Titel
        <input type="text" name="title" /> <br />

        Datum
        <select name="day">
            <option value="tag">Tag</option>
            <option value="01">01</option>
            <option value="02">02</option>
            <option value="03">03</option>
            <option value="04">04</option>
            <option value="05">05</option>
            <option value="06">06</option>
            <option value="07">07</option>
            <option value="08">08</option>
            <option value="09">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
            <option value="24">24</option>
            <option value="25">25</option>
            <option value="26">26</option>
            <option value="27">27</option>
            <option value="28">28</option>
            <option value="29">29</option>
            <option value="30">30</option>
            <option value="31">31</option>
        </select>
        <select name="month">
            <option value="monat">Monat</option>
            <option value="01">01</option>
            <option value="02">02</option>
            <option value="03">03</option>
            <option value="04">04</option>
            <option value="05">05</option>
            <option value="06">06</option>
            <option value="07">07</option>
            <option value="08">08</option>
            <option value="09">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
        </select>
        <select name="year">
            <option value="jahr">Jahr</option>
            <option value="2015">2015</option>
            <option value="2014">2014</option>
        </select>
        </div>
        <br />
        Anfang - Ende
        <select name="open">
            <option value="00:00">00:00</option>
            <option value="00:30">00:30</option>
            <option value="01:00">01:00</option>
            <option value="01:30">01:30</option>
            <option value="02:00">02:00</option>
            <option value="02:30">02:30</option>
            <option value="03:00">03:00</option>
            <option value="03:30">03:30</option>
            <option value="04:00">04:00</option>
            <option value="04:30">04:30</option>
            <option value="05:00">05:00</option>
            <option value="05:30">05:30</option>
            <option value="06:00">06:00</option>
            <option value="06:30">06:30</option>
            <option value="07:00">07:00</option>
            <option value="07:30">07:30</option>
            <option value="08:00">08:00</option>
            <option value="08:30">08:30</option>
            <option value="09:00">09:00</option>
            <option value="09:30">09:30</option>
            <option value="10:00">10:00</option>
            <option value="10:30">10:30</option>
            <option value="11:00">11:00</option>
            <option value="11:30">11:30</option>
            <option value="12:00">12:00</option>
            <option value="12:30">12:30</option>
            <option value="13:00">13:00</option>
            <option value="13:30">13:30</option>
            <option value="14:00">14:00</option>
            <option value="14:30">14:30</option>
            <option value="15:00">15:00</option>
            <option value="15:30">15:30</option>
            <option value="16:00">16:00</option>
            <option value="16:30">16:30</option>
            <option value="17:00">17:00</option>
            <option value="17:30">17:30</option>
            <option value="18:00">18:00</option>
            <option value="18:30">18:30</option>
            <option value="19:00">19:00</option>
            <option value="19:30">19:30</option>
            <option value="20:00">20:00</option>
            <option value="20:30">20:30</option>
            <option value="21:00">21:00</option>
            <option value="21:30">21:30</option>
            <option value="22:00">22:00</option>
            <option value="22:30">22:30</option>
            <option value="23:00">23:00</option>
            <option value="23:30">23:30</option>
        </select>
        -
        <select name="close">
            <option value="0">Ausblenden</option>
            <option value="00:00">00:00</option>
            <option value="00:30">00:30</option>
            <option value="01:00">01:00</option>
            <option value="01:30">01:30</option>
            <option value="02:00">02:00</option>
            <option value="02:30">02:30</option>
            <option value="03:00">03:00</option>
            <option value="03:30">03:30</option>
            <option value="04:00">04:00</option>
            <option value="04:30">04:30</option>
            <option value="05:00">05:00</option>
            <option value="05:30">05:30</option>
            <option value="06:00">06:00</option>
            <option value="06:30">06:30</option>
            <option value="07:00">07:00</option>
            <option value="07:30">07:30</option>
            <option value="08:00">08:00</option>
            <option value="08:30">08:30</option>
            <option value="09:00">09:00</option>
            <option value="09:30">09:30</option>
            <option value="10:00">10:00</option>
            <option value="10:30">10:30</option>
            <option value="11:00">11:00</option>
            <option value="11:30">11:30</option>
            <option value="12:00">12:00</option>
            <option value="12:30">12:30</option>
            <option value="13:00">13:00</option>
            <option value="13:30">13:30</option>
            <option value="14:00">14:00</option>
            <option value="14:30">14:30</option>
            <option value="15:00">15:00</option>
            <option value="15:30">15:30</option>
            <option value="16:00">16:00</option>
            <option value="16:30">16:30</option>
            <option value="17:00">17:00</option>
            <option value="17:30">17:30</option>
            <option value="18:00">18:00</option>
            <option value="18:30">18:30</option>
            <option value="19:00">19:00</option>
            <option value="19:30">19:30</option>
            <option value="20:00">20:00</option>
            <option value="20:30">20:30</option>
            <option value="21:00">21:00</option>
            <option value="21:30">21:30</option>
            <option value="22:00">22:00</option>
            <option value="22:30">22:30</option>
            <option value="23:00">23:00</option>
            <option value="23:30">23:30</option>
        </select>
        <br />
        Bild
        <input type="file" name="image_file"> <br />

        <br />
        Beschreibung <br />
        <textarea name="description" style="width: 700px; height: 400px"></textarea><br />
        <br />

        <input type="submit" name="submit" value="Event erstellen">

    </form>

<?php

}

?>

</body>
</html>