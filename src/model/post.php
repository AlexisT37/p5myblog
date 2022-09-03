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
    public string $identifier;
}

class PostRepository
{
    public DatabaseConnection $connection;

    public function getPost(string $identifier): Post
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT id, title, content, leadParagraph, DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date FROM posts WHERE id = ?"
        );
        $statement->execute([$identifier]);

        $row = $statement->fetch();
        $post = new Post();
        $post->title = $row['title'];
        $post->frenchCreationDate = $row['french_creation_date'];
        $post->content = $row['content'];
        $post->leadParagraph = $row['leadParagraph'];
        $post->identifier = $row['id'];

        return $post;
    }

    public function getPosts(): array
    {
        $statement = $this->connection->getConnection()->query(
            "SELECT id, title, content, leadParagraph, DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date FROM posts ORDER BY creation_date DESC LIMIT 0, 5"
        );
        $posts = [];
        while (($row = $statement->fetch())) {
            $post = new Post();
            $post->title = $row['title'];
            $post->leadParagraph = $row['leadParagraph'];
            $post->frenchCreationDate = $row['french_creation_date'];
            $post->content = $row['content'];
            $post->identifier = $row['id'];

            $posts[] = $post;
        }

        return $posts;
    }

    public function createPost(string $title, string $author, string $leadParagraph, string $content): bool
    {
        $statement = $this->connection->getConnection()->prepare(
            'INSERT INTO posts(title, author, leadParagrahp, content, creation_date) VALUES(?, ?, ?, ?, NOW())'
        );
        $affectedLines = $statement->execute([$title, $author, $leadParagraph, $content]);

        return ($affectedLines > 0);
    }
}
