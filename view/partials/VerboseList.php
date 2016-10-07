<?php

class VerboseList{

  private $memberList;

  public function __construct($memberList){
    $this->memberList = $memberList;
  }

//for ($i = 0; $i < count($this->memberList); $i++) {
//$currentMember = $this->memberList[$i];
//$boatCount = count($currentMember['boats']);
//$str .= "
//      <div class='listBox'>
//      name: {$currentMember['member']['memberName']}<br>
//      id: {$currentMember['member']['ID']}<br>
//      Number of boats: {$boatCount}
//      </div>
//      ";
//
//}

  public function show(){
    $str = "";

      for ($i = 0; $i < count($this->memberList); $i++) {
          $currentMember = $this->memberList[$i];
          $boatList = $this->boatList($currentMember);


          $str .= "
      <div class='listBox'>
      name: {$currentMember['member']['memberName']}<br>
      personal id: {$currentMember['member']['passportNumber']}<br>
      id: {$currentMember['member']['ID']}

      <dd>Boat: $boatList</dd>
      </div>
      ";
      }
//
//    foreach ($this->memberList as $key => $value) {
//      $boatList = $this->boatList($key['boats']);
//      $str .= "
//      <div class='listBox'>
//      name: {$key['firstName']} {$key['lastName']}<br>
//      personal id: {$key['personalId']}<br>
//      id: {$key['memberId']}
//      {$boatList}
//      </div>
//      ";
//    }

      return $str;
  }

  private function boatlist($member) {

      $str = "";

      if (isset($member['boats'])) {

          foreach ($member['boats'] as $key => $value) {
              $str .= "
              (<a href='&action=editBoat&boatId={$value['ID']}'>edit</a>
                 <a href='&action=deleteBoat&boatId={$value['ID']}'>Delete</a>)
      </dt>
      <dd>Type:&nbsp;&nbsp;&nbsp;{$value['type']}</dd>
      <dd>Length: {$value['length']}</dd>
              ";
          }

      } else {
          $str = "No boats";
      }

      return $str;
  }

//  private function boatlist(){
//    $str = "<a href='&action=addBoat&boatId={$value->memberId}'>Add boat</a><dl>";
//
//    foreach ($this->boats as $key => $value) {
//      $str .= "
//      <dt>Boat {$key}
//        (<a href='&action=editBoat&boatId={$value->boatId}'>edit</a>
//        <a href='&action=deleteBoat&boatId={$value->boatId}'>Delete</a>)
//      </dt>
//      <dd>Type:&nbsp;&nbsp;&nbsp;{$value->type}</dd>
//      <dd>Length: {$value->length}</dd>
//      ";
//    }
//
//    return $str . "</dl>";
//  }

}
