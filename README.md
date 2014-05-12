Eventraider SDK - PHP
========

Die Eventraider SDK ermöglicht einen Zugriff auf die Eventraider API.
Beispiel sind unter demo zu finden.

Benutzung
--------------

Dieses Beispiel zeigt, wie ein Event erstellt werden kann.

```php
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
		exit();

	}
	$location = $response->getLocationObject();

	if ($location->getID() < 0) {

		echo "Fatal error: Es wurde noch kein Standort gesetzt. \n
		Melde dich mit deinem Konto an und stelle unter \"Einstellungen > Marker\" deinen Standort ein.";
		exit();

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
		exit();

	}

	echo $response->getData()."\n";

} else {

	echo "Session konnte nicht initialisiert werden.\n";

}
```
