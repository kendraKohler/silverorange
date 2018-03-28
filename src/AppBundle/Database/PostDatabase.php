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
        error_log('ABOUT TO SAVE POST');
        $exists = $this->checkPostExists($postModel->id());
        error_log('EXISTS IS: ' . $exists);

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

    public function getPostById($id)
    {
        /*
         * Get post and it's author data by id
         * NOTE : although all data is not needed for this part, 
         * all data is grabbed so the model will contain everything
         * for any future needs.
         */
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

        $stmt->bindParam(':id',$id);
        $stmt->execute();
        $result = $stmt->fetch();

        $model = $this->setModels($result);

        return $model;
    }

    public function getAllPosts()
    {
        $models = [];
        /*
         * Get all posts and their author data
         */
        $result = $this->connection->query('
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

        foreach($result as $row)
        {
            $model = $this->setModels($row);
            $models[] = $model;
        }

        return $models;
    }

    private function checkPostExists($id)
    {
        $stmt = $this->connection->prepare('SELECT exists(SELECT 1 FROM posts WHERE id = :id');

        $stmt->bindParam(':id',$id);
        $stmt->execute();
        $result = $stmt->fetch();

        error_log('RESULT IS: ' .print_r($result,1) );
    }

    private function setModels($result)
    {
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

        return $postModel;
    }
}
