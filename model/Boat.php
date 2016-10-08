<?php
namespace model;
require_once("Validate.php");

class Boat {

    private $type;
    private $length;

    public function __construct() {
        $this->validate = new Validate();
    }

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

        $this->validate->checkLength($length, $minLength, $maxLength);
        $this->length = $length;
    }
}
