<?php
namespace model;
// standard local/root db settings file in project root (unsafe but for simplicity of running the code).

class registryDatabase {


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
            memberName VARCHAR(30) NOT NULL,
            passportNumber VARCHAR(30) NOT NULL,
            ID VARCHAR(13) NOT NULL,
            numberOfBoats INT(2)
        )";

        $boatTable = "CREATE TABLE IF NOT EXISTS boats (
            type VARCHAR(12) NOT NULL,
            length INT(6) NOT NULL,
            ID VARCHAR(13) NOT NULL,
            ownerID INT(6),
            ownerName VARCHAR(30)
        )";

        $this->config = $dbConfig;
        $this->registry = $this->connectDatabase();
        $this->registry->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->registry->exec($memberTable);
        $this->registry->exec($boatTable);

    }


    public function createBoat(Boat $boat) {
        //         $this->connectDatabase();

        $uniqueId = uniqid();
        echo $uniqueId;

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
        echo $uniqueId;

        $memberSchema = $this->registry->prepare("INSERT INTO members (memberName, passportNumber, ID, numberOfBoats)" . "VALUES (:memberName, :passportNumber, :ID, :numberOfBoats)");
        $memberSchema->execute(array(
            "memberName" => $member->getMemberName(),
            "passportNumber" => $member->getPassportNumber(),
            "ID" => $uniqueId,
            "numberOfBoats" => 0
        ));

    }


    public function update() {

    }

    private function get($id, $whichDB) {

        $query = $this->registry->prepare("SELECT * FROM $whichDB WHERE ID = '$id'");
        $query->execute();
        $result = $query->fetch();

        return $result;


    }

    private function getBoat($id) {
        return $this->get($id, "boats");

    }

    private function getMember($id) {
        return $this->get($id, "members");
    }



    public function removeBoatFor($memberID, $boatID) {


    }

    public function registerBoatFor($memberID, $boatID) {


        // returns Array ( [memberName] => Lars, [passportNumber] => 343434, [ID] => 57f63bf2ab790, [numberOfBoats] => 0 )
        $member = $this->getMember($memberID);

        // returns Array ([type] => Other, [length] => 7, [ID] => 57f63bf2abbe9, [ownerID] => "", [type] => Other, [ownerName] => )
        $boat = $this->getBoat($boatID);

        $statementUpdateMember = $this->registry->prepare("UPDATE members SET numberOfBoats = numberOfBoats + :addOne WHERE ID = :memberID");
        $statmenetUpdateBoat = $this->registry->prepare("UPDATE boats SET ownerID = :memberID WHERE ID = :boatID");

        $addOne = 1;
        $retrievedMemberID = $member["ID"];
        $boatID = $boat["ID"];

        $statementUpdateMember->bindParam(":addOne", $addOne, \PDO::PARAM_INT);
        $statementUpdateMember->bindParam(":memberID", $retrievedMemberID);
        $statementUpdateMember->execute();

        $statmenetUpdateBoat->bindParam(":boatID", $boatID);
        $statmenetUpdateBoat->execute();

    }


    public function listMembers(bool $compactList) {

        //“Compact List”; name, member id and number of boats
        //“Verbose List”; name, personal number, member id and boats with boat information

        if ($compactList === true) {
            $compactListQuery = $this->registry->prepare("SELECT COUNT(*) memberName, ID, numberOfBoats  FROM members");
            $compactListQuery->execute();
            $compactList = $compactListQuery->fetch();

            echo $compactList;


        } else if ($compactList === false) {
            $verboseMemberListQuery = $this->registry->prepare("SELECT COUNT(*) memberName, ID, passPortNumber  FROM members");
            $verboseMemberListQuery->execute();
            $verboseMemberList = $verboseMemberListQuery->fetch();

            echo $verboseMemberList;

            //$verboseBoatListQuery = $this->registry->prepare("SELECT COUNT(*) memberName, memberID  FROM members");
        }
    }

}