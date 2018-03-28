<?php

namespace AppBundle\Database;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\Query\ResultSetMapping;

use AppBundle\Model\PostModel;

class PostDatabase
{
	private $connection;

	public function __construct(Connection $connection)
	{
		$this->connection = $connection;
	}

    public function savePost(PostModel $postModel)
    {
        try
        {
            $stmt = $connection->prepare("INSERT INTO posts (id, title, body, created_at, modified_at, author) 
            VALUES (:id, :title, :body, :created_at, :modified_at, :author)");

            $stmt->bindParam(':id',$postModel->id());
            $stmt->bindParam(':title',$postModel->title());
            $stmt->bindParam(':body',$postModel->body());
            $stmt->bindParam(':created_at',$postModel->createdAt());
            $stmt->bindParam(':modified_at',$postModel->modifiedAt());
            $stmt->bindParam(':author',$postModel->author());

            $stmt->execute();
        }
        catch(Exception $e)
        {
            error_log("ERROR: " . $e->getMessage());
        }
    }
}
