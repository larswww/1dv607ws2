<?php

class UpdateMemberForm{

  private $id;
  private $firstname;
  private $lastname;
  private $personalNumber;

  public function __construct(\model\Member $member){
    $this->id = $member->getID();
    $this->firstname = $member->getFirstName();
    $this->lastname = $member->getLastName();
    $this->personalNumber = $member->getPassportNumber();

  }

  public function show(){
    return "
    <form action='?action=updateMember&id={$this->id}' method='POST'>

    <input type='hidden' name='id' value={$this->id}>

    <legend>First name
      <input type='text' name='firstname' value='{$this->firstname}'>
    </legend>

    <legend>Last name
      <input type='text' name='lastname' value='{$this->lastname}'>
    </legend>

    <legend>Personal identity number
      <input type='text' name='personalNumber' value='{$this->personalNumber}'>
    </legend>

    <input type='submit' name='UpdateMember'>
    <a href='?action=deleteMember&id={$this->id}'>Delete member</a>
    ";
  }
}
