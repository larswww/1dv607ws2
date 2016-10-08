<?php

class VerboseList{

  private $memberList;

  public function __construct($memberList){
    $this->memberList = $memberList;
  }

  public function show(){
    $str = "";

      for ($i = 0; $i < count($this->memberList); $i++) {
          $currentMember = $this->memberList[$i];
          $boatList = $this->boatList($currentMember);


          $str .= "
      <div class='listBox'>
      name: {$currentMember['member']['firstName']} {$currentMember['member']['lastName']}<br>
      personal id: {$currentMember['member']['passportNumber']}<br>
      id: {$currentMember['member']['ID']}

      <dd>Boat: $boatList</dd>
      </div>
      ";
      }

      return $str;
  }

  private function boatlist($member) {

      $str = "";

      if (isset($member['boats'][0])) {

          foreach ($member['boats'] as $key => $value) {
              $str .= "
              (<a href='?action=editBoat&boatId={$value['ID']}'>edit</a>
                 <a href='?action=deleteBoat&boatId={$value['ID']}'>Delete</a>)
      </dt>
      <dd>Type:&nbsp;&nbsp;&nbsp;{$value['type']}</dd>
      <dd>Length: {$value['length']}</dd>
              ";
          }

      } else {
          $str .= "No boats";
      }

      return $str;
  }

}
