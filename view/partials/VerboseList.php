<?php

class VerboseList{

  private $memberList;

  public function __construct($memberList){
    $this->memberList = $memberList;
  }

  public function show(){
    $boatList = $this->boatList();
    $str = "";

    foreach ($this->memberList as $key => $value) {
      $boatList = $this->boatList($key['boats']);
      $str .= "
      <div class='listBox'>
      name: {$key['firstName']} {$key['lastName']}<br>
      personal id: {$key['personalId']}<br>
      id: {$key['memberId']}
      {$boatList}
      </div>
      ";
    }
  }

  private function boatlist(){
    $str = "<a href='&action=addBoat&memberId={$value->memberId}'>Add boat</a><dl>";

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

}
