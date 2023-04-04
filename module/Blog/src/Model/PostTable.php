<?php 

namespace Blog\Model;

use Zend\Db\TableGateway\TableGatewayInterface;

class PostTable
{
    protected $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;   
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select(); 
        return $resultSet; 
    }

    public function save(Post $post) 
    {
        $data = [
            'title' => $post->title,
            'content' => $post->content
        ];

        if ((int)$post->id === 0) {
            $this->tableGateway->insert($data);
            return;
        }
    }

}