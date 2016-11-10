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



        $memberDB = "CREATE TABLE IF NOT EXISTS memberObjects (
        memberObject VARCHAR(5000) NOT NULL,
        ID VARCHAR(13) NOT NULL
        )";


        $this->config = $dbConfig;
        $this->validate = new Validate();
        $this->registry = $this->connectDatabase();
        $this->registry->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->registry->exec($memberDB);
    }


    public function createBoat(Boat $boat) {

        $uniqueId = uniqid();

        $serializedMember = serialize($boat);
        $testSchema = $this->registry->prepare("INSERT INTO boatObjects (boatObject, ID)" . "VALUES (:boatObject, :ID)");
        $testSchema->execute(array(
            "boatObject" => $serializedMember,
            "ID" => $uniqueId
        ));

        return $uniqueId;

    }

    public function createMember(Member $member) {
        $serializedMember = serialize($member);
        $testSchema = $this->registry->prepare("INSERT INTO memberObjects (memberObject, ID)" . "VALUES (:memberObject, :ID)");
        $testSchema->execute(array(
            "memberObject" => $serializedMember,
            "ID" => $member->getID()
        ));

    }

    public function deleteMember($memberID) {
        $this->validate->validateID($memberID);

        $sql = $this->registry->prepare("DELETE FROM memberObjects WHERE ID='$memberID'");
        $sql->execute();

    }

    public function deleteBoat($boatID) {
        $this->validate->validateID($boatID);

        $sql = $this->registry->prepare("DELETE FROM boatObjects WHERE ID='$boatID'");
        $sql->execute();

    }


    public function updateMember($memberID, Member $newDetails) {

        $this->validate->validateID($memberID);
        $updatedMemberObject = serialize($newDetails);

        $updateMemberSchema = $this->registry->prepare("UPDATE memberObjects SET memberObject = :updatedMember WHERE ID = :memberID");
        $updateMemberSchema->bindParam(":updatedMember", $updatedMemberObject);
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
        $result = $this->get($id, "memberObjects");
        $memberObject = unserialize($result[0]);
        return $memberObject;
    }


    public function getAllMembers() : array {

        $allMembersQuery = $this->registry->prepare("SELECT memberObject FROM memberObjects");
        $allMembersQuery->execute();
        $allMembersQuery = $allMembersQuery->fetchAll();

        return $allMembersQuery;

    }

    public function listMembers() : array {

        $allMembersQuery = $this->getAllMembers();


        $unserializdedMemberObjects = Array();

        for ($i = 0; $i < count($allMembersQuery); $i++) {
            array_push($unserializdedMemberObjects, unserialize($allMembersQuery[$i]['memberObject']));

        }

        return $unserializdedMemberObjects;
    }
}
