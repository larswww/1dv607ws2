<?php

class VerboseList
{

    private $memberList;

    public function __construct($memberList)
    {
        $this->memberList = $memberList;
    }

    public function show()
    {
        $str = "";


      for ($i = 0; $i < count($this->memberList); $i++) {
          $currentMember = $this->memberList[$i];

          $boats = $currentMember->getBoats();
          $id = $currentMember->getID();
          $boatList = $this->boatlist($boats, $id);

          $firstname = $currentMember->getFirstName();
          $lastname = $currentMember->getLastName();
          $personalNumber = $currentMember->getPassportNumber();

          $str .= "
          <div class='listBox'>
          <a href='?action=viewMember&id={$id}'>view member info</a><br>
          name: {$firstname} {$lastname}<br>
          personal id: {$personalNumber}<br>
          id: {$id}

          <dd>Boat: $boatList</dd>
          </div>
      ";
        }

        return $str;
    }

    private function boatlist($memberBoats, $memberID)
    {

        $str = "";

        if (count($memberBoats) > 0) {


          for ($i = 0; $i < count($memberBoats); $i++) {
              $type = $memberBoats[$i]->getBoatType();
              $length = $memberBoats[$i]->getBoatLength();
              $str .= "
              <dt>
              <a href='?action=editBoat&boatId={$i}&memberId={$memberID}'>edit</a><br>
              <a href='?action=deleteBoat&boatId={$i}&memberId={$memberID}'>Delete</a>
              </dt>

              <dd>Type:&nbsp;&nbsp;&nbsp;{$type}</dd>
              <dd>Length: {$length}</dd>
              ";
            }

        } else {
            $str .= "No boats";
        }

        return $str;
    }

}
