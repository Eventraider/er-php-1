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
 * Class EventraiderSession
 * @package Eventraider
 *
 * @author Daniel Schultz <dschultz@eventraider.com>
 */
class EventraiderSession {

    /**
     * @var String Token
     */
    private $token;

    public function getToken()
    {

        return $this->token;

    }

    /**
     * Fügt einen Token hinzu.
     *
     * @param String $api_key
     * @param String $api_secret
     * @throws EventraiderException
     */
    public function __construct($api_key, $api_secret)
    {

        if (empty($api_key) || empty($api_secret)) {

            throw new EventraiderException("Der API-Schlüssel oder das API-Geheimnis fehlt.");

        }

        $this->token = $api_key.':'.$api_secret;

    }

}