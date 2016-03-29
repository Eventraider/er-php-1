Eventraider SDK - PHP
========

Die Eventraider SDK ermöglicht einen Zugriff auf die Eventraider API.<br />
Beispiele sind unter "demo" zu finden.<br />
<br />
Die Zugangsdaten befinden sich unter Einstellungen -> API, der jeweiligen Seite.

Sandbox
--------------

Im Sandbox Modus werden alle Daten an die Server übertragen und verarbeitet.
Diese werden allerdings nicht dauerhaft gespeichert. <br />

Damit die Sandbox angesteurt werden kann, muss folgende Konstante definiert werden

```php

define ('SANDBOX', 1);

```

Beispiel
--------------

Dieses Beispiel zeigt, wie ein Event erstellt werden kann.

```php

namespace Eventraider\demo;
use Eventraider;

define ('PRINT_ERROR', true);
define ('LOG_ERROR', true);
define ('ER_SDK_DIR', __DIR__.'PFAD/ZUR/SDK' );

require_once(ER_SDK_DIR.'EventraiderSession.php');
require_once(ER_SDK_DIR.'EventraiderRequest.php');
require_once(ER_SDK_DIR.'EventraiderResponse.php');
require_once(ER_SDK_DIR.'EventraiderException.php');
require_once(ER_SDK_DIR.'EventraiderLocation.php');

try {

	$session = new \Eventraider\EventraiderSession(
		APP_KEY,
		APP_SECRET
	);

} catch (\Eventraider\EventraiderException $e) {

	if (PRINT_ERROR) {
		echo 'Fehler: '.$e->getMessage()."\n";
	}

	if (LOG_ERROR) {
		 error_log('Eventraider: '.$e->getMessage());
	}

}

if (isset($session)) {

	$request = new \Eventraider\EventraiderRequest($session, '/me/location',
		'GET', array('ID' => -1));

	try {

		$response = $request->execute();

	} catch (\Eventraider\EventraiderException $e) {

		if (PRINT_ERROR) {
			echo 'Fehler: '.$e->getMessage()."\n";
		}

		if (LOG_ERROR) {
			error_log('Eventraider: '.$e->getMessage());
		}

		exit();

	}
	$location = $response->getLocationObject();

	if ($location->getID() < 0) {

		if (PRINT_ERROR) {
			echo "Fehler: Es wurde noch kein Standort gesetzt. \n
Melde dich mit deinem Konto an und stelle unter \"Einstellungen > Marker\" deinen Standort ein.";
		}

		if (LOG_ERROR) {
			error_log('Eventraider: Es wurde noch kein Standort gesetzt. \n
Melde dich mit deinem Konto an und stelle unter \"Einstellungen > Marker\" deinen Standort ein.');
		}

		exit();

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
		'specials' => $_POST['specials'],
		'price' => $_POST['price'],
		'ageRating' => $_POST['ageRating'],
		'publish' => true
	);

	$request = new \Eventraider\EventraiderRequest($session, '/event', 'POST',
		$event);

	try {

		$response = $request->execute();

	} catch (\Eventraider\EventraiderException $e) {

		if (PRINT_ERROR) {
			echo 'Fehler: '.$e->getMessage()."\n";
		}

		if (LOG_ERROR) {
			error_log('Eventraider: '.$e->getMessage());
		}

		exit();

	}

	if ($response->getCode() != 201) {

		if (PRINT_ERROR) {
			echo "Fehler: Das Event \"".$_POST['title']."\" konnte nicht erstellt werden.\n";
		}

		if (LOG_ERROR) {
			error_log('Eventraider: Das Event "'.$_POST['title'].'" konnte nicht erstellt werden.');
		}

	} else {

			echo $response->getData()."\n";

	}

} else {

	if (PRINT_ERROR) {
		echo "Fehler: Session konnte nicht initialisiert werden.\n";
	}

	if (LOG_ERROR) {
		error_log('Eventraider: Session konnte nicht initialisiert werden.');
	}

}
```

Schnittstelle
--------------

\Eventraider\EventraiderRequest($session, URI, TYPE, POST);

/me/... ist eine Umleitung auf /page/{ID}/... bezogen auf die Session.

Erklärung der Post typen:
 * Image: Ein Bild als File-Objekt. Erlaubt sind jpeg, jpg und png.
 * String: Eine Zeichenkette
 * Date: Datum im Format yyyy:mm:dd
 * Time: Uhrzeit im Format hh:mm
 * Double: Eine Zahl mit Nachkommastellen
 * Int: Eine Zahl ohne Nachkommastellen

| URI                            | TYPE   | POST  |  Notiz  |
| ------------------------------ | ------ | ----- |  ------ |
| /raider/{ID}                   | GET    |       |         |
| /raider/{ID}/stream[/{OFFSET}] | GET    |       |         |
| /raider/{ID}/follows[/{OFFSET}]| GET    |       |         |
| /page/{ID}                     | GET    |       |         |
| /page/{ID}/follow              | POST   |       |         |
| /page/{ID}/follow              | DELETE |       |         |
| /page/{ID}/events[/{OFFSET}]   | GET    |       |         |
| /page/{ID}/images[/{OFFSET}]   | GET    |       |         |
| /page/{ID}/location            | GET    |       |         |
| /page/{ID}/image               | POST   | file:Image | Ändert das Seiten Banner. |
| /page/{ID}/images[/{OFFSET}]   | GET    |       |         |
| /event                         | POST   | date:Date<br />title:String{3-255}<br />start:Time<br />end:Time<br />locationID:Int<br />image:Image<br />price:Double{0-200}<br />ageRating:Int{0-99}<br />description:String{3-2000}<br />[specials:String{0-2000}]<br />[publish:Boolean]<br /> |        |
| /event/{ID}                    | GET    |       |         |
| /event/{ID}                    | PUT    | description:String | Ändert die Event Beschreibung. |
| /event/{ID}/image              | POST   | file:Image |         |
| /event/{ID}/timer              | POST   | name:String{3-36}<br />duration:Int<br />start:Time |         |
| /event/{ID}/timer[/{OFFSET}]   | GET    |       |         |
| /event/{ID}/timer/{timerID}    | DELETE |       |         |
| /event/{ID}/images[/{OFFSET}]  | GET    |       |         |





