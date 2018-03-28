<?php

namespace AppBundle\Database;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\Query\ResultSetMapping;

use AppBundle\Model\PostModel;
use AppBundle\Model\AuthorModel;

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
            $stmt = $this->connection->prepare("INSERT INTO posts (id, title, body, created_at, modified_at, author) 
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

    public function getPostById($id)
    {
        /*
         * Get post and it's author data by id
         * NOTE : although all data is not needed for this task, 
         * all data is grabbed so the model will contain everything
         * for any future needs.
         */
        $stmt = $this->connection->query('
            SELECT p.id AS post_id, 
                p.title AS post_title, 
                p.body AS post_body, 
                p.created_at AS post_created_at, 
                p.modified_at AS post_modified_at, 
                a.id AS author_id, 
                a.full_name AS author_full_name,
                a.created_at AS author_created_at,
                a.modified_at AS author_modified_at
            FROM posts p JOIN authors a ON p.author = a.id');
        $row = $stmt->fetchAll();

        error_log('ROW DATA FETCHED ON JOIN: ' . print_r($row,1));

        //Populate author model
        //$authorModel = new AuthorModel();
        //$authorModel->initialize();

        //Populate post model
        //$postModel = new PostModel();
            //$model->setId($row['id']);
        return 'DATABASE FUNCTIONALITY TO BE ADDED';
    }
}
