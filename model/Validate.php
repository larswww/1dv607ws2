<?php
namespace model;

class Validate {
    public function containsScript($userInput) {

        $sanitizedInput = htmlentities($userInput, ENT_QUOTES | ENT_IGNORE, "UTF-8");

        if ($sanitizedInput !== $userInput) {
            throw new \Exception("Entry contains forbidden script characters, you h4x0r.");
        }

    }
}
/**
 * Created by PhpStorm.
 * User: MBAi
 * Date: 07/10/2016
 * Time: 1:29 AM
 */