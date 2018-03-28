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
        try
        {
            $stmt = $this->connection->prepare('
                SELECT p.id AS post_id, 
                    p.title AS post_title, 
                    p.body AS post_body, 
                    p.created_at AS post_created_at, 
                    p.modified_at AS post_modified_at, 
                    a.id AS author_id, 
                    a.full_name AS author_full_name,
                    a.created_at AS author_created_at,
                    a.modified_at AS author_modified_at
                FROM posts p JOIN authors a ON p.author = a.id
                WHERE p.id = :id');

            error_log('ID IS: ' .$id );

            $stmt->bindParam(':id',$id);
            $stmt->execute();
            $result = $stmt->fetch();
        }
        catch(Exception $e)
        {
            error_log("ERROR: " . $e->getMessage());
        }

        error_log("Result from query is: " . print_r($result,1));


        //Populate author model
        $authorModel = new AuthorModel();
        $authorModel->initialize(
            $result['author_id'],
            $result['author_full_name'],
            $result['author_created_at'],
            $result['author_modified_at']);

        //Populate post model
        $postModel = new PostModel();
        $postModel->initialize(
            $result['post_id'],
            $result['post_title'],
            $result['post_body'],
            $result['post_created_at'],
            $result['post_modified_at'],
            $authorModel);

        error_log("POST MODEL IN DB: " . print_r($postModel,1));

        return $postModel;
    }
}
