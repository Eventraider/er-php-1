<?php

namespace Eventraider\demo;
use Eventraider;

define ('PRINT_ERROR', true);
define ('LOG_ERROR', true);
define ('ER_SDK_DIR', __DIR__.'/../src/Eventraider/' );

require_once(ER_SDK_DIR.'EventraiderSession.php');
require_once(ER_SDK_DIR.'EventraiderRequest.php');
require_once(ER_SDK_DIR.'EventraiderResponse.php');
require_once(ER_SDK_DIR.'EventraiderException.php');
require_once(ER_SDK_DIR.'EventraiderLocation.php');

//Bei Problemen oder Fehlern die '//' der nächsten Zeile entfernen
//ini_set('display_errors', 1);

function exit_request() {

	echo '
				</ul>
			</div>
            <div id="footer">
                Eventraider &copy; '.date('Y').' - <a href="http://www.eventraider.com/impressum" title="Nutzungsbestimmungen">Nutzungsbestimmungen</a>
            </div>

		</div>
	</body>
</html>';

	exit();
}

?>

<!DOCTYPE html>
<html>
	<head>
    	<title>API Demo</title>
    	<meta charset="utf-8">
		<link rel="Stylesheet" href="http://static.eventraider.com/css/eventraider.template.css">
	</head>
	<body>

		<div id="header">
			<div class="content">
                <div class="caption">Eventraider</div>
				<div class="navigation">
                    <a href="http://support.eventraider.com/api" title="API">
                        API
                    </a>
                    <a href="http://support.eventraider.com/signup" title="Registrieren">
                        Registrieren
                    </a>
                    <a href="http://www.eventraider.com" title="Startseite">
                        Startseite
                    </a>
				</div>
			</div>	
		</div>

		<div id="wrapper">
			<div class="section">
				<h2>Veranstaltung erstellen</h2>




<?php

//Sollte das Input File nicht den namen "image_file" haben, muss der name angepasst werden
//$_FILES['image_file'] = $_FILES['filename'];

if (isset($_FILES['image_file']) && !empty($_FILES['image_file'])) {

?>

				<ul class="text">

<?php

    try {

        //Unter Einstellungen > API werden die API Zugangsdaten angezeigt
        $session = new \Eventraider\EventraiderSession('APP_KEY', 'APP_SECRET');

    } catch (\Eventraider\EventraiderException $e) {

        if (PRINT_ERROR)
            echo '<li>Fehler (1): '.$e->getMessage().'</li>';

        if (LOG_ERROR)
            error_log('Eventraider: '.$e->getMessage());

    }

    if (isset($session)) {

        //event location holen
        $request = new \Eventraider\EventraiderRequest(
			$session,
			'me/location',
			'GET',
			array('ID' => -1)
		);
        try {

            $response = $request->execute();

        } catch (\Eventraider\EventraiderException $e) {

            if (PRINT_ERROR)
                echo '<li>Fehler (2): '.$e->getMessage().'</li>';

            if (LOG_ERROR)
                error_log('Eventraider: '.$e->getMessage());

            unset($_FILES['image_file']);
            echo '<li><a href="javascript:window.location.href=window.location.href">zurück</a></li>';
            exit_request();

        }

        $location = $response->getLocationObject();

        if ($location->getID() < 0) {

            if (PRINT_ERROR)
                echo '<li>Fehler: Es wurde noch kein Standort gesetzt. <br />
            Melde dich mit deinem Konto an und stelle unter \"Einstellungen > Marker\" deinen Standort ein.<li>';

            if (LOG_ERROR)
                error_log('Eventraider: Es wurde noch kein Standort gesetzt. \n
            Melde dich mit deinem Konto an und stelle unter \"Einstellungen > Marker\" deinen Standort ein.');

        }

        $date = $_POST['year'].'-'.$_POST['month'].'-'.$_POST['day'];

        $event = array(
            'date' => $date,
            'title' => $_POST['title'],
            'start' => $_POST['open'],
            'end' => $_POST['close'],
            'locationID' => $location->getID(),
            'image' => $_FILES['image_file'],
            'description' => $_POST['description'],
            'license' => null
        );

        $request = new \Eventraider\EventraiderRequest(
			$session,
			'event',
			'POST',
			$event
		);
        try {

            $response = $request->execute();

        } catch (\Eventraider\EventraiderException $e) {

            if (PRINT_ERROR)
                echo '</li>Fehler (3): '.$e->getMessage().'</li>';

            if (LOG_ERROR)
                error_log('Eventraider: '.$e->getMessage());

            unset($_FILES['image_file']);
            echo '<li><a href="javascript:window.location.href=window.location.href">zurück</a></li>';
            exit_request();

        }

        if ($response->getCode() != 201) {

            if (PRINT_ERROR)
                echo '<li>Fehler: Das Event "'.$_POST['title'].'" konnte nicht erstellt werden.</li>';

            if (LOG_ERROR)
                error_log('Eventraider: Das Event "'.$_POST['title'].'" konnte nicht erstellt werden.');

        }

    } else {

        if (PRINT_ERROR)
            echo "<li>Fehler (4): Session konnte nicht initialisiert werden.</li>";

        if (LOG_ERROR)
            error_log('Eventraider: Session konnte nicht initialisiert werden.');

    }

    if (PRINT_ERROR)
        echo '<li>Das Event wurde erstellt.</li>';

    unset($_FILES['image_file']);
    echo '<a href="javascript:window.location.href=window.location.href">zurück</a>';

	?>

				</ul>

	<?php

} else {

    ?>

				<div class="content">
					<form method="post" enctype="multipart/form-data">

						<div class="label">Title</div>
						<input type="text" name="title" />

						<div class="label">Datum</div>
						<select name="day">
							<?php
								echo '
								<option value="'.date('d').'">
									'.date('d').'
								</option>';
							?>
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
							<?php
								echo '
								<option value="'.date('m').'">
									'.date('m').'
								</option>';
							?>
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
							<?php
								echo '
								<option value="'.date('o').'">
									'.date('o').'
								</option>';
							?>
							<option value="2015">2015</option>
							<option value="2014">2014</option>
						</select>

						<div class="label">Anfang - Ende</div>
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

						<div class="label">Bild</div>
						<input type="file" name="image_file"> <br />

						<div class="label">Beschreibung</div>
						<textarea name="description" style="width: 700px; height: 400px"></textarea><br />

						<input type="submit" name="submit" value="Event erstellen">

					</form>

				</div>

<?php

}

?>

			</div>
            <div id="footer">
                Eventraider &copy; <?php echo date('Y'); ?> - <a href="http://www.eventraider.com/impressum" title="Nutzungsbestimmungen">Nutzungsbestimmungen</a>
            </div>

		</div>
	</body>
</html>
