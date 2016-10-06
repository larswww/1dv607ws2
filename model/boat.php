<?php
namespace model;

class Boat {

        // enum Sailboat, Motorsailer, kayak/Canoe, Other
    private $type;
    private $length;


    public function getBoatType() {
        return $this->type;
    }

    public function setBoatType($type) {
        // validation // enum thing here
        $this->type = $type;
    }

    public function getBoatLength() {
        return $this->length;

    }

    public function setBoatLength($length) {
        $this->length = $length;

    }





}

/**
 * Created by PhpStorm.
 * User: MBAi
 * Date: 04/10/2016
 * Time: 8:21 PM
 */