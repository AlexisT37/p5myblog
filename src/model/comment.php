<?php

namespace Application\Model\Comment;


class Comment
{
    public int $identifier;
    public int $author;
    public string $frenchCreationDate;
    public string $frenchModifiedDate;
    public string $comment;
    public string $post;
    public int $validated = 0;
    public int $deleted;
}
