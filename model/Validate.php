<?php
namespace model;

class Validate {

    public function containsScript($userInput) {

        $sanitizedInput = htmlentities($userInput, ENT_QUOTES | ENT_IGNORE, "UTF-8");

        if ($sanitizedInput !== $userInput) {
            throw new \Exception("Entry contains forbidden script characters, you h4x0r.");
        }

    }

    static function checkLength($userInput, $minLength, $maxLength) {
        if ($userInput > $maxLength) {
            throw new \Exception("Input can be maximum " . $maxLength . "characters.");
        }

        if ($userInput < $minLength) {
            throw new \Exception("Input must be minimum " . $minLength . "characters.");
        }
    }

    public function validateID($id) {

        if (strlen($id) !== 13) {
            throw new \Exception("ID not valid");
        }

    }


}
/**
 * Created by PhpStorm.
 * User: MBAi
 * Date: 07/10/2016
 * Time: 1:29 AM
 */