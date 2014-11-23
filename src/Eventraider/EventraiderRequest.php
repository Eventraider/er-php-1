<?php

/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2014 Eventraider
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace Eventraider;

/**
 * Class EventraiderRequest
 * @package Eventraider
 *
 * @author Daniel Schultz <dschultz@eventraider.com>
 */
class EventraiderRequest {

    /**
     * @var float Eventraider API Version
     */
    private $api_version = 1.0;

    /**
     * @const String Eventraider API URL
     */
    const URI = 'http://phalcon.api.eventraider.com/';
    /**
     * @const String OAuth API URL
     */
    //const OAUTH = 'http://oauth.eventraider.com';

    /**
     * @var EventraiderSession Session für die Anfragen
     */
    private $session;

    /**
     * @var String Die Funktion, die ausgeführt werden soll
     */
    private $function;

    /**
     * @var String HTTP Methode
     */
    private $method;

    /**
     * @var Array POST Variablen
     */
    private $parameter;

    /**
     * Speichert alle Werte für einen Zugriff auf die APIs
     *
     * @param EventraiderSession $session
     * @param $function
     * @param string $method
     * @param null $parameter
     */
    public function __construct(EventraiderSession $session, $function, $method = 'GET', $parameter = null) {

        $this->session = $session;
        $this->function = $function;
        $this->method = $method;
        $this->parameter = $parameter;

    }

    /**
     * Führt einen Zugriff auf die Eventraider API aus.
     *
     * @return EventraiderResponse
     * @throws EventraiderException
     */
    public function execute()
    {


        if (!extension_loaded('curl')) {

            //  cURL installieren (UNIX):
            //  apt-get install php5-curl
            //  /etc/init.d/apache2 restart
            throw new EventraiderException("cURL muss als PHP Extension installiert sein.");

        }

        //open connection
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this::URI.$this->function);

        //Header
        // FIXME - Auch HTML
        $headers = array(
            'Accept: application/json',
            'ER-API-No: '.$this->api_version
        );
        $token = $this->session->getToken();

        if (empty($token)) {

            throw new EventraiderException("Es wurde kein Token gefunden.\nToken mit der EventraiderSession Klasse generieren");

        }

        curl_setopt($ch, CURLOPT_USERPWD, $token);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 1);

        //FIXME - timeout

        //data
        if ($this->method == 'POST') {

            curl_setopt($ch, CURLOPT_POST, 1);

        } else if ($this->method == 'PUT') {

            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");

        } else if ($this->method == 'DELETE') {

            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");

        }

        if ($this->method == 'POST' || $this->method == 'PUT') {

            // Files Paramter
            if (!empty($this->parameter['image'])) {

                $this->parameter['type'] = $this->parameter['image']['type'];
                $this->parameter['file'] = '@'.$this->parameter['image']['tmp_name'];

            }

            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->parameter);

        }

        $result = curl_exec($ch);

        if (curl_errno($ch) > 0) {

            throw new EventraiderException('Request failed: '.curl_error($ch));

        }

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $body = substr($result, $header_size);

        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $response = json_decode($body, true);

        if ($http_status != 200 && $http_status != 201) {

            throw new EventraiderException($response['msg'], $http_status);

        }

        return new EventraiderResponse($this, $http_status, $response['msg']);

    }

}