<?php


function redirect($path)
{
    header('location:' . URLROOT . "/" . $path);
}

function slugGenerator($data)
{
    $post = trim($data->title);
    $newPost = explode(" ", $post);
    $newPost = implode("-", $newPost);
    return $newPost;
}

function slugDeGenerator($title)
{
    $title = explode("-", $title);
    $title = implode(" ", $title);
    return $title;
}

