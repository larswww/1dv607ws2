<?php
namespace model;

class Member {

    private $name;

    // "personal number" is a bad translation of Personnummer in req's, which in some countries would be Social Security Number.
    // a personal number can be anything, a social security number follows a certain format and contains numbers/letters
    // and dashes depening on country... could also be passport number etc.. so the requirement is not clear.
    // i made it into passportNumber since that's a globally recognized thing that everyone has. (and it'd be easier to get formatting, presumably).
    private $passportNumber;
    private $memberID;

    public function getMemberName() {
        return $this->name;
    }

    public function setMemberName($name) {
        $this->name = $name;
    }

    public function getPassportNumber() {
        return $this->passportNumber;
    }

    public function setPassportNumber($passportNumber) {
        $this->passportNumber = $passportNumber;
    }

    public function getMemberID() {
        return $this->memberID;
    }

    public function setMemberID($id) {
        $this->memberID = $id;
    }
}
/**
 * Created by PhpStorm.
 * User: MBAi
 * Date: 04/10/2016
 * Time: 8:21 PM
 */