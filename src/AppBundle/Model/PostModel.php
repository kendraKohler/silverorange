<?php
namespace AppBundle\Model;

class PostModel
{
    private $id;
    private $title;
    private $body;
    private $createdAt;
    private $modifiedAt;
    private $author;

    public function __construct($id,$title,$body,$createdAt,$modifiedAt,$author)
    {
        $this->id = $id;
        $this->title = $title;
        $this->body = $body;
        $this->createdAt = $createdAt;
        $this->modifiedAt = $modifiedAt;
        $this->author = $author;
    }
    
    public function id()
    {
        return $this->id;
    }
    public function title()
    {
        return $this->title;
    }
    public function body()
    {
        return $this->body;
    }
    public function createdAt()
    {
        return $this->createdAt;
    }
    public function modifiedAt()
    {
        return $this->modifiedAt;
    }
    public function author()
    {
        return $this->author;
    }
}