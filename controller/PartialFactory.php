<?php
require_once("IncomingParams.php");

class PartialFactory{

  private $action;
  private $db;
  private $memberModel;
  private $boatModel;
  private $incomingParams;

  public function __construct($database, $member, $boat){
    $this->action = (!empty($_GET) && isset($_GET['action']) && function_exists($$_GET['action'])) ? $_GET['action'] : 'blank';
    $this->db = $database;
    $this->memberModel = $member;
    $this->boatModel = $boat;
    $this->incomingParams = new IncomingParams();
  }

  public function getRenderedPartial(){
    try {
      $partialFunction = $this->action;
      $partial = $this->$partialFunction();
    } catch (Exception $e) {
      return new Errorpartial($e->getMessage());
    }

    return $partial;
  }

  private function blank(){
    return new Blank();
  }

  private function compactList(){
    $data = $this->db->listMembers();
    return new CompactList($data);
  }

  private function verboseList(){
    $data = $this->db->listMembers();
    return new VerboseList($data);
  }

  private function editBoat(){
    $ip = $this->incomingParams;

    if($ip->noIncomingParams){
      $id = $_GET['boatId'];
      $boat = $this->db->getBoat($id);
      return new UpdateBoatForm($boat['ID'], $boat['length'], $boat['type']);
    }

    $this->boatModel->setBoatLength($ip->length);
    $this->boatModel->setBoatType($ip->type);

    $data = $this->db->updateBoat($ip->boatId, $this->boatModel);
    return new BoatUpdated();
  }

  private function deleteBoat(){
    $this->db->deleteBoat($_GET['boatId']);
    return new BoatDeleted();
  }

  private function deleteMember(){
    $this->db->deleteMember($_GET['memberId']);
    return new MemberDeleted();
  }

  private function addBoat() {
    $ip = $this->incomingParams;
    if($ip->noIncomingParams){
      return new AddBoatForm();
    }

    $this->boatModel->setBoatType($ip->type);
    $this->boatModel->setBoatLength($ip->length);

    $boatId = $this->db->createBoat($this->boatModel);
    $this->db->registerBoatFor($ip->memberId, $boatId);

    return new BoatCreated();
  }

  private function viewMember(){
    $memberData = $this->db->listMembers($_GET['id']);

    return new ViewMember($memberData);
  }

  private function UpdateMember(){
    $ip = $this->incomingParams;
    $m = $this->db->getMember($_GET['id']);

    if($ip->noIncomingParams){
      return new UpdateMemberForm($m['ID'], $m['firstName'], $m['lastName'], $m['passportNumber'], $m['numberOfBoats']);
    }

    $this->memberModel->setMemberName($ip->firstname, $ip->lastname);
    $this->memberModel->setPassportNumber($ip->personalNumber);

    $this->db->updateMember($ip->id, $this->memberModel);

    return new MemberUpdated();
  }

  private function createNewMember() {
    $ip = $this->incomingParams;
    if($ip->noIncomingParams){
      return new CreateMemberForm();
    }

    $this->memberModel->setMemberName($ip->firstname, $ip->lastname);
    $this->memberModel->setPassportNumber($ip->personalNumber);

    $this->db->createMember($this->memberModel);

    return new MemberCreated();
  }
}
