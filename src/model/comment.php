<?php

namespace Application\Model\Comment;

require_once('C:/laragon/www/p5myblog/src/lib/database.php');
require_once('C:/laragon/www/p5myblog/src/classes/JWT.php');
require_once('C:/laragon/www/p5myblog/src/config.php');

use JWT;
use Application\Lib\Database\DatabaseConnection;
use Application\Model\User\UserRepository;

class Comment
{
    public int $identifier;
    public int $author;
    public string $frenchCreationDate;
    public string $comment;
    public string $post;
    public int $validated = 0;
}

class CommentRepository
{
    public DatabaseConnection $connection;

    public function getComments(string $post): array
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT id, author, comment, validated, DATE_FORMAT(comment_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date, post_id FROM comments WHERE post_id = ? ORDER BY comment_date DESC"
        );
        $statement->execute([$post]);

        $comments = [];
        while (($row = $statement->fetch())) {
            $comment = new Comment();
            $comment->identifier = $row['id'];
            $comment->author = $row['author'];
            $comment->frenchCreationDate = $row['french_creation_date'];
            $comment->comment = $row['comment'];
            $comment->post = $row['post_id'];
            $comment->validated = $row['validated'];

            $comments[] = $comment;
        }

        return $comments;
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

        $tokenFromCookies = $_COOKIE['TOKEN'];
        $tokenVerifProcess = new JWT();
        $validToken = $tokenVerifProcess->check($tokenFromCookies, SECRET);
        if ($validToken === true) {
            $decodedTokenInfo = $tokenVerifProcess->getPayload($tokenFromCookies);
            $author = $decodedTokenInfo['user_id'];
            //getUser: since the author is a string, we want to get the author's id
            $statementUser = $this->connection->getConnection()->prepare(
                "SELECT id FROM user WHERE username = ?"
            );
            $statementUser->execute([$author]);
            $authorStatement = $statementUser->fetch();
            $author = $authorStatement['id'];

            $statement = $this->connection->getConnection()->prepare(
                'INSERT INTO comments(post_id, author, comment, comment_date) VALUES(?, ?, ?, NOW())'
            );
            $affectedLines = $statement->execute([$post, $author, $comment]);

            return ($affectedLines > 0);
        } else {
            header('Location: index.php');
        }
    }

    public function updateComment(int $identifier, string $comment): bool
    {
        $tokenFromCookies = $_COOKIE['TOKEN'];
        $tokenVerifProcess = new JWT();
        $validToken = $tokenVerifProcess->check($tokenFromCookies, SECRET);
        if ($validToken === true) {
            $decodedTokenInfo = $tokenVerifProcess->getPayload($tokenFromCookies);
            $authorUsername = $decodedTokenInfo['user_id'];
            $authorFetchId = new UserRepository();
            $author = $authorFetchId->getUserIdFromName($authorUsername);

            $statement = $this->connection->getConnection()->prepare(
                'UPDATE comments SET author = ?, comment = ? WHERE id = ?'
            );
            $affectedLines = $statement->execute([$author, $comment, $identifier]);

            return ($affectedLines > 0);
        } else {
            throw new \Exception('Token invalide.');
        }
    }
}
