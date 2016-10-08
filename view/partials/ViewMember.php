<?php
class ViewMember{

  private $memberId;
  private $firstname;
  private $lastname;
  private $personalNumber;
  private $boats;

  public function __construct($memberId, $firstname, $lastname, $personalNumber, $boats){

    $this->memberId = $memberId;
    $this->firstname = $firstname;
    $this->lastname = $lastname;
    $this->personalNumber = $personalNumber;
    $this->boats = $boats;
  }

  private function boatlist(){
    var_dump($this->boats);

    if(!$this->boats){
      return "No boats";
    }

    $str = "<dl>";
    foreach ($this->boats as $key => $value) {
      $str .= "
      <dt>Boat {$key}
        (<a href='&action=editBoat&boatId={$value->boatId}'>edit</a>
        <a href='&action=deleteBoat&boatId={$value->boatId}'>Delete</a>)
      </dt>
      <dd>Type:&nbsp;&nbsp;&nbsp;{$value->type}</dd>
      <dd>Length: {$value->length}</dd>
      ";
    }
    return $str . "</dl>";
  }

  public function show(){
    $boatlist = $this->boatlist();
    return "
    <div>
      <span>name: {$this->firstname} {$this->lastname}</span>
      <span>Personal number: {$this->personalNumber}</span>
      {$boatlist}
    </div>
    <a href='?action=deleteMember&memberId={$this->memberId}'>Delete member</a>
    <a href='?action=updateMember&id={$this->memberId}'>Update member info</a>
    <a href='?action=addBoat&memberId={$this->memberId}'>Add a boat</a>
    ";
  }
}
