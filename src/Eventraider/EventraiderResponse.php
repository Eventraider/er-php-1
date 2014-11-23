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
use Eventraider\htdocs\EventraiderLocation;

/**
 * Class EventraiderResponse
 * @package Eventraider
 *
 * @author Daniel Schultz <dschultz@eventraider.com>
 */
class EventraiderResponse {

    /**
     * @var EventraiderRequest original Request Object
     */
    private $request;

    /**
     * @var int Status Code des Requests
     */
    private $code;

    /**
     * @var mixed Daten die von der API geliefert werden
     */
    private $data;
    

    public function __construct($request, $code, $data)
    {
        $this->request = $request;
        $this->code = $code;
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getCode()
    {
        return $this->code;
    }

    /**
     * Erstellt ein EventraiderLocation Object
     *
     * @return EventraiderLocation
     */
    public function getLocationObject()
    {

        $obj = new EventraiderLocation();
        foreach ($this->data as $key => $value) {

            $obj->$key = $value;

        }

        return $obj;

    }

}