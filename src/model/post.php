<?php

namespace Application\Model\Post;

use DateTime;

class Post
{   
    public int $userId;
    public string $title;
    public string $frenchCreationDate;
    public string $content;
    public string $leadParagraph;
    public int $identifier;
    public int $validated = 0;
    public DateTime $creationDate;
    public Datetime $modifiedDate;
    public int $deleted;
}
