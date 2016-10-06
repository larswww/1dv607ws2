<?php
namespace model;
require_once("Validate.php");

class Boat {

        // enum Sailboat, Motorsailer, kayak/Canoe, Other

    private $type;
    private $length;




    public function getBoatType() {
        return $this->type;
    }

    public function setBoatType($type)  {

        // TODO use an enum or something thats easier to extend
        if ($type === "Sailboat" || $type === "Motorsailer" || $type === "kayak/Canoe") {
            $this->type = $type;
        } else {
            $this->type = "Other";
        }


    }

    public function getBoatLength() {


        return $this->length;

    }

    public function setBoatLength($length) {
        $minLength = 0;
        $maxLength = 20;

        Validate::checkLength($length, $minLength, $maxLength);
        $this->length = $length;

    }
}

/**
 * Created by PhpStorm.
 * User: MBAi
 * Date: 04/10/2016
 * Time: 8:21 PM
 */