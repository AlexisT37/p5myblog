<?php

namespace Application\Controllers\Comment\CommentRepository;

require_once('../src/lib/database.php');
require_once('../src/classes/JWT.php');
require_once('../src/config.php');
require_once('../src/model/comment.php');
require_once('../src/controllers/user/UserRepository.php');


use JWT;
use Application\Lib\Database\DatabaseConnection;
use Dotenv\DotEnv;
use Application\Model\Comment\Comment;
use Application\Controllers\User\UserRepository\UserRepository;


class CommentRepository extends Comment
{
    public DatabaseConnection $connection;

    public function validateComment(int $identifier): bool
    {
        $statement = $this->connection->getConnection()->prepare(
            'UPDATE comments SET validated = 1 WHERE id = ?'
        );
        $affectedLines = $statement->execute([$identifier]);

        return ($affectedLines > 0);
    }

    public function getUnvalidatedComments(): array
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT id, author, comment, validated, DATE_FORMAT(comment_date, 'créé le %d/%m/%Y à %Hh%imin%ss') AS french_creation_date, post_id, DATE_FORMAT(modified_date, '%d/%m/%Y à %Hh%imin%ss') AS french_modified_date FROM comments WHERE validated = 0 ORDER BY comment_date DESC"
        );
        $statement->execute([]);

        $comments = [];
        while (($row = $statement->fetch())) {
            $comment = new Comment();
            $comment->identifier = $row['id'];
            $comment->author = $row['author'];
            $comment->frenchCreationDate = $row['french_creation_date'];
            $comment->frenchModifiedDate = $row['french_modified_date'];
            $comment->comment = $row['comment'];
            $comment->post = $row['post_id'];
            $comment->validated = $row['validated'];

            $comments[] = $comment;
        }

        return $comments;
    }

    public function getComments(string $post): array
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT id, author, comment, validated, deleted, DATE_FORMAT(comment_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date, post_id, DATE_FORMAT(modified_date, '%d/%m/%Y à %Hh%imin%ss') AS french_modified_date FROM comments WHERE post_id = ? ORDER BY comment_date DESC"
        );
        $statement->execute([$post]);

        $comments = [];
        while (($row = $statement->fetch())) {
            $comment = new Comment();
            $comment->identifier = $row['id'];
            $comment->author = $row['author'];
            $comment->frenchCreationDate = $row['french_creation_date'];
            $comment->frenchModifiedDate = $row['french_modified_date'];
            $comment->comment = $row['comment'];
            $comment->post = $row['post_id'];
            $comment->validated = $row['validated'];
            $comment->deleted = $row['deleted'];


            $comments[] = $comment;
        }

        return $comments;
    }

    public function deleteComment(int $id): bool
    {
        $statement = $this->connection->getConnection()->prepare(
            'UPDATE comments SET deleted = 1 WHERE id = ?'
        );
        $affectedLines = $statement->execute([$id]);

        return ($affectedLines > 0);
    }

    public function getComment(int $identifier): ?Comment
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT id, author, comment, validated, DATE_FORMAT(comment_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date, post_id FROM comments WHERE id = ?"
        );
        $statement->execute([$identifier]);

        $row = $statement->fetch();
        if ($row === false) {
            return null;
        }

        $comment = new Comment();
        $comment->identifier = $row['id'];
        $comment->author = $row['author'];
        $comment->frenchCreationDate = $row['french_creation_date'];
        $comment->comment = $row['comment'];
        $comment->post = $row['post_id'];
        $comment->validated = $row['validated'];


        return $comment;
    }

    public function createComment(int $post, string $author = null, string $comment): bool
    {
        (new DotEnv("../.env"))->load();
        $SECRET = getenv('SECRET');

        $tokenFromCookies = $_COOKIE['TOKEN'];
        $tokenVerifProcess = new JWT();
        $validToken = $tokenVerifProcess->check($tokenFromCookies, $SECRET);
        if ($validToken === true) {
            $decodedTokenInfo = $tokenVerifProcess->getPayload($tokenFromCookies);
            $author = $decodedTokenInfo['username'];
            //getUser: since the author is a string, we want to get the author's id
            $statementUser = $this->connection->getConnection()->prepare(
                "SELECT id FROM user WHERE username = ?"
            );
            $statementUser->execute([$author]);
            $authorStatement = $statementUser->fetch();
            $author = $authorStatement['id'];

            $statement = $this->connection->getConnection()->prepare(
                'INSERT INTO comments(post_id, author, comment, comment_date, modified_date) VALUES(?, ?, ?, NOW(), NOW())'
            );
            $affectedLines = $statement->execute([$post, $author, $comment]);

            return ($affectedLines > 0);
        } else {
            header('Location: index.php');
        }
    }

    public function updateComment(int $identifier, string $comment): bool
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
                'UPDATE comments SET author = ?, comment = ?, modified_date = NOW() WHERE id = ?'
            );
            $affectedLines = $statement->execute([$author, $comment, $identifier]);

            return ($affectedLines > 0);
        } else {
            throw new \Exception('Token invalide.');
        }
    }
}
