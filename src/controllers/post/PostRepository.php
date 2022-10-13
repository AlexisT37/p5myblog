<?php

namespace Application\Controllers\Post\PostRepository;

require_once('../src/classes/JWT.php');
require_once('../src/lib/database.php');
require_once('../src/config.php');
require_once('../src/model/post.php');
require_once('../src/controllers/user/UserRepository.php');




use Application\Lib\Database\DatabaseConnection;
use Application\Controllers\User\UserRepository\UserRepository;
use Application\Model\Post\Post;

use JWT;
use Dotenv\DotEnv;

class PostRepository extends Post
{
    public DatabaseConnection $connection;

    public function createPost(string $title,  string $content, string $leadParagraph, int $UserId): bool
    {
        $statement = $this->connection->getConnection()->prepare(
            'INSERT INTO posts(title, content, leadParagraph, User_Id, creation_date, modified_date) VALUES(?, ?, ?, ?, NOW(), NOW())'
        );
        $affectedLines = $statement->execute([$title, $content, $leadParagraph, $UserId]);

        return ($affectedLines > 0);
    }

    public function getPost(int $identifier): Post
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT id, title, content, User_Id, leadParagraph, validated, DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date FROM posts WHERE id = ?"
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
        $post->userId = $row['User_Id'];

        return $post;
    }

    public function getPosts(): array
    {
        $statement = $this->connection->getConnection()->query(
            "SELECT id, title, content, leadParagraph, validated, deleted,User_id, DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date FROM posts ORDER BY modified_date DESC LIMIT 0, 5"
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
            $post->deleted = $row['deleted'];
            $post->userId = $row['User_id'];


            $posts[] = $post;
        }

        return $posts;
    }

    public function validatePost(int $id): bool
    {
        $statement = $this->connection->getConnection()->prepare(
            'UPDATE posts SET validated = 1 WHERE id = ?'
        );
        $affectedLines = $statement->execute([$id]);

        return ($affectedLines > 0);
    }

    public function deletePost(int $id): bool
    {
        $statement = $this->connection->getConnection()->prepare(
            'UPDATE posts SET deleted = 1 WHERE id = ?'
        );
        $affectedLines = $statement->execute([$id]);

        return ($affectedLines > 0);
    }

    public function updatePost(int $identifier, string $content, string $leadParagraph, string $title): bool
    {

        (new DotEnv("../.env"))->load();
        $SECRET = getenv('SECRET');

        $tokenFromCookies = $_COOKIE['TOKEN'];
        $tokenVerifProcess = new JWT();
        $validToken = $tokenVerifProcess->check($tokenFromCookies, $SECRET);
        if ($validToken === true) {
            $decodedTokenInfo = $tokenVerifProcess->getPayload($tokenFromCookies);
            $authorUsername = $decodedTokenInfo['username'];
            $authorFetchId = new UserRepository();
            $author = $authorFetchId->getUserIdFromName($authorUsername);

            $statement = $this->connection->getConnection()->prepare(
                'UPDATE posts SET content = ?, leadParagraph = ?, title = ?, modified_date = NOW() WHERE id = ?'
            );
            $affectedLines = $statement->execute([$content, $leadParagraph, $title, $identifier]);

            return ($affectedLines > 0);
        } else {
            throw new \Exception('Token invalide.');
        }
    }
}
