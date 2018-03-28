<?php
namespace AppBundle\Model;

class AuthorModel
{
    private $id;
    private $fullName;
    private $createdAt;
    private $modifiedAt;

    public function initialize($id,$fullName,$createdAt,$modifiedAt)
    {
        $this->id = $id;
        $this->fullName = $fullName;
        $this->createdAt = $createdAt;
        $this->modifiedAt = $modifiedAt;
    }
    
    public function id()
    {
        return $this->id;
    }
    public function fullName()
    {
        return $this->fullName;
    }
    public function createdAt()
    {
        return $this->createdAt;
    }
    public function modifiedAt()
    {
        return $this->modifiedAt;
    }
}