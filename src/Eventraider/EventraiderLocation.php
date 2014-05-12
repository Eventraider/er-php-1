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

namespace Eventraider\htdocs;


class EventraiderLocation {

    /**
     * @var Array Location daten
     */
    private $data;

    /**
     * Füllt den $data Array
     *
     * @param $key
     * @param $value
     */
    public function __set($key, $value) {

        $this->data[$key] = $value;

    }

    /**
     * ID der Location
     *
     * Existiert keine Location, ist die ID -1
     *
     * @return integer
     */
    public function getID()
    {
        return $this->data['ID'];
    }

    /**
     * Latitude der Location
     *
     * @return double|null
     */
    public function getLatitude()
    {
        return $this->data['locationX'];
    }

    /**
     * Longitude der Location
     *
     * @return double|null
     */
    public function getLongitude()
    {
        return $this->data['locationY'];
    }

    /**
     * Straßenname der Location
     *
     * @return String|null
     */
    public function getStreet()
    {
        return $this->data['street'];
    }

    /**
     * Hausnummer der Location
     *
     * @return String|null
     */
    public function getStreetNumber()
    {
        return $this->data['streetNumber'];
    }

    /**
     * Stadtname der Location
     *
     * @return String|null
     */
    public function getCity()
    {
        return $this->data['city'];
    }

    /**
     * Postleitzahl der Location
     *
     * @return integer|null
     */
    public function getZipcode()
    {
        return $this->data['zipcode'];
    }

}