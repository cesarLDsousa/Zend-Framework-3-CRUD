<?php 

namespace Blog\Model;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

class Post
{
    public $id;
    public $title;
    public $content;
    
    public function exchangeArray(array $data) 
    {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->title = (!empty($data['title'])) ? $data['title'] : null;
        $this->content = (!empty($data['content'])) ? $data['content'] : null;
    }

    public function getArrayCopy()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content
        ];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this->id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this->title;
    }

    public function setContent($content)
    {
        $this->content = $content;
        return $this->content;
    }

}