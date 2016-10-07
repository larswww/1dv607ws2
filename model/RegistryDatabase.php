<?php
namespace model;
require_once("Validate.php");

class RegistryDatabase {

    //TODO
        // refactor functions to increase abstraction level
        // try catch and throw exceptions
        // run arguments through validation


    private function connectDatabase() {
        try {
            $dbSettingString = "mysql:host=" . $this->config["host"] . ";dbname=" . $this->config["name"] . ";port=" . $this->config["port"] . ";charset=" . $this->config["charset"];
            return new \PDO($dbSettingString, $this->config["username"], $this->config["password"]);

        } catch (\PDOException $exception) {
            echo "db connection failed";
            exit;
        }
    }

    public function __construct() {

        $dbConfig = [
                "host" => "127.0.0.1",
            "port" => "8889",
            "name" => "membersAndBoats",
            "username" => "root",
            "password" => "root",
            "charset" => "utf8"
        ];

        $memberTable = "CREATE TABLE IF NOT EXISTS members (
            firstName VARCHAR(30) NOT NULL,
            lastName VARCHAR(30) NOT NULL,
            passportNumber VARCHAR(30) NOT NULL,
            ID VARCHAR(13) NOT NULL,
            numberOfBoats INT(2)
        )";

        $boatTable = "CREATE TABLE IF NOT EXISTS boats (
            type VARCHAR(12) NOT NULL,
            length INT(6) NOT NULL,
            ID VARCHAR(13) NOT NULL,
            ownerID VARCHAR(13),
            ownerName VARCHAR(30)
        )";

        $this->config = $dbConfig;
        $this->validate = new Validate();
        $this->registry = $this->connectDatabase();
        $this->registry->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->registry->exec($memberTable);
        $this->registry->exec($boatTable);

    }


    public function createBoat(Boat $boat) {

        $uniqueId = uniqid();

        $boatSchema = $this->registry->prepare("INSERT INTO boats (type, length, ID)" . "VALUES (:type, :length, :ID)");
        $boatSchema->execute(array(
            "type" => $boat->getBoatType(),
            "length" => $boat->getBoatLength(),
            "ID" => $uniqueId
        ));

    }

    public function createMember(Member $member) {
        //         $this->connectDatabase();
        $uniqueId = uniqid();

        $memberSchema = $this->registry->prepare("INSERT INTO members (firstName, lastName, passportNumber, ID)" . "VALUES (:firstName, :lastName, :passportNumber, :ID)");
        $memberSchema->execute(array(
            "firstName" => $member->getFirstName(),
            "lastName" => $member->getLastName(),
            "passportNumber" => $member->getPassportNumber(),
            "ID" => $uniqueId
        ));

    }

    //TODO should these be combined into 1?
    public function deleteMember($memberID) {
        $this->validate->validateID($memberID);

        $sql = $this->registry->prepare("DELETE FROM members WHERE ID='$memberID'");
        $sql->execute();

    }

    public function deleteBoat($boatID) {
        $this->validate->validateID($boatID);

        $sql = $this->registry->prepare("DELETE FROM boats WHERE ID='$boatID'");
        $sql->execute();

    }


    public function updateMember($memberID, Member $newDetails) {

        $this->validate->validateID($memberID);
        $newMemberFirstName = $newDetails->getFirstName();
        $newMemberLastName = $newDetails->getLastName();
        $newPassportNumber = $newDetails->getPassportNumber();

        $updateMemberSchema = $this->registry->prepare("UPDATE members SET firstName = :newFirstName, lastName = :newLastName, passportNumber = :newPassportNumber WHERE ID = :memberID");
        $updateMemberSchema->bindParam(":newFirstName", $newMemberFirstName);
        $updateMemberSchema->bindParam(":newLastName", $newMemberLastName);
        $updateMemberSchema->bindParam(":newPassportNumber", $newPassportNumber);
        $updateMemberSchema->bindParam(":memberID", $memberID);
        $updateMemberSchema->execute();

    }

    public function updateBoat($boatID, Boat $newDetails) {

        $newBoatType = $newDetails->getBoatType();
        $newBoatLength = $newDetails->getBoatLength();

        $updateBoatSchema = $this->registry->prepare("UPDATE boats SET type = :newBoatType, length = :newBoatLength WHERE ID = :boatID");
        $updateBoatSchema->bindParam(":newBoatType", $newBoatType);
        $updateBoatSchema->bindParam(":newBoatLength", $newBoatLength);
        $updateBoatSchema->bindParam(":boatID", $boatID);
        $updateBoatSchema->execute();


    }

    private function get($id, $whichDB) {

        $query = $this->registry->prepare("SELECT * FROM $whichDB WHERE ID = '$id'");
        $query->execute();
        $result = $query->fetch();

        return $result;


    }

    public function getBoat($id) {
        return $this->get($id, "boats");

    }

    public function getMember($id) {
        return $this->get($id, "members");
    }



    public function removeBoatFor($memberID, $boatID) {
            try {
            $member = $this->getMember($memberID);
            $boat = $this->getBoat($boatID);

            $statementUpdateMember = $this->registry->prepare("UPDATE members SET numberOfBoats = numberOfBoats - :addOne WHERE ID = :memberID");
            $statementUpdateBoat = $this->registry->prepare("UPDATE boats SET ownerID = :none WHERE ownerID = :memberID");

            $addOne = 1;
            $retrievedMemberID = $member["ID"];

            $statementUpdateMember->bindParam(":addOne", $addOne, \PDO::PARAM_INT);
            $statementUpdateMember->bindParam(":memberID", $retrievedMemberID);
            $statementUpdateMember->execute();

                $null = NULL; // TODO this seems retarded

            $statementUpdateBoat->bindParam(":none", $null);
            $statementUpdateBoat->bindParam(":memberID", $retrievedMemberID);
            $statementUpdateBoat->execute();

        } catch (\Exception $e) {

        }


    }

    public function registerBoatFor($memberID, $boatID) {


        // returns Array ( [memberName] => Lars, [passportNumber] => 343434, [ID] => 57f63bf2ab790, [numberOfBoats] => 0 )

        try {
            $member = $this->getMember($memberID);

            // returns Array ([type] => Other, [length] => 7, [ID] => 57f63bf2abbe9, [ownerID] => "", [type] => Other, [ownerName] => )
            $boat = $this->getBoat($boatID);

            $statementUpdateMember = $this->registry->prepare("UPDATE members SET numberOfBoats = numberOfBoats + :addOne WHERE ID = :memberID");
            $statementUpdateBoat = $this->registry->prepare("UPDATE boats SET ownerID = :memberID WHERE ID = :boatID");

            $addOne = 1;
            $retrievedMemberID = $member["ID"];
            $retrievedBoatID = $boat["ID"];

            $statementUpdateMember->bindParam(":addOne", $addOne, \PDO::PARAM_INT);
            $statementUpdateMember->bindParam(":memberID", $retrievedMemberID);
            $statementUpdateMember->execute();

            $statementUpdateBoat->bindParam(":boatID", $retrievedBoatID);
            $statementUpdateBoat->bindParam(":memberID", $retrievedMemberID);
            $statementUpdateBoat->execute();

        } catch (\Exception $e) {
            throw new \Exception("Database failed to register boat for member");
        }

    }


    public function listMembers() : array {

        $allMembersQuery = $this->registry->prepare("SELECT passportNumber, firstName, lastName, ID FROM members");
        $allMembersQuery->execute();
        $allMembersQuery = $allMembersQuery->fetchAll();

        $allBoatsQuery = $this->registry->prepare("SELECT type, length, ID, ownerID FROM boats");
        $allBoatsQuery->execute();
        $allBoatsQuery = $allBoatsQuery->fetchAll();

        $membersAndBoats = Array();

        for ($i = 0; $i < count($allMembersQuery); $i++) {
            $currentArrayEntry = Array();
            $currentArrayEntry["member"] = $allMembersQuery[$i];
            $currentArrayEntry["boats"] = Array();
            $currentMemberID = $allMembersQuery[$i]["ID"];

            for ($x = 0; $x < count($allBoatsQuery); $x++) {
                if ($allBoatsQuery[$x]["ownerID"] === $currentMemberID) {
                    array_push($currentArrayEntry["boats"], $allBoatsQuery[$x]);
                }
            }

            // set it to NULL if not?

            array_push($membersAndBoats, $currentArrayEntry);

        }

        return $membersAndBoats;

    }
}