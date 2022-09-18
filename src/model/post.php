<?php

namespace Application\Model\Post;

require_once('../src/lib/database.php');

use Application\Lib\Database\DatabaseConnection;

class Post
{
    public string $title;
    public string $frenchCreationDate;
    public string $content;
    public string $leadParagraph;
    public int $identifier;
    public int $validated = 0;
}

class PostRepository
{
    public DatabaseConnection $connection;

    public function createPost(string $title,  string $content, string $leadParagraph, $UserId): bool
    {
        $statement = $this->connection->getConnection()->prepare(
            'INSERT INTO posts(title, content, leadParagraph, User_Id, creation_date) VALUES(?, ?, ?, ?, NOW())'
        );
        $affectedLines = $statement->execute([$title, $content, $leadParagraph, $UserId]);

        return ($affectedLines > 0);
    }

    public function getPost(int $identifier): Post
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT id, title, content, leadParagraph, validated, DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date FROM posts WHERE id = ?"
        );
        $statement->execute([$identifier]);

        $row = $statement->fetch();
        $post = new Post();
        $post->title = $row['title'];
        $post->frenchCreationDate = $row['french_creation_date'];
        $post->content = $row['content'];
        $post->leadParagraph = $row['leadParagraph'];
        $post->identifier = $row['id'];
        $post->validated = $row['validated'];

        return $post;
    }

    public function getPosts(): array
    {
        $statement = $this->connection->getConnection()->query(
            "SELECT id, title, content, leadParagraph, validated, DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date FROM posts ORDER BY modified_date DESC LIMIT 0, 5"
        );
        $posts = [];
        while (($row = $statement->fetch())) {
            $post = new Post();
            $post->title = $row['title'];
            $post->leadParagraph = $row['leadParagraph'];
            $post->frenchCreationDate = $row['french_creation_date'];
            $post->content = $row['content'];
            $post->identifier = $row['id'];
            $post->validated = $row['validated'];


            $posts[] = $post;
        }

        return $posts;
    }

    public function validatePost($id): bool
    {
        $statement = $this->connection->getConnection()->prepare(
            'UPDATE posts SET validated = 1 WHERE id = ?'
        );
        $affectedLines = $statement->execute([$id]);

        return ($affectedLines > 0);
    }
}
