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

    public function save($post) 
    {
        $data = [
            'title' => $post->title,
            'content' => $post->content
        ];

        $id = (int) $post->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (!$this->find($id)) {
            throw new \RuntimeException(sprintf(
                'Could not retrieve the row %d', $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function find($id) // return one register
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();

        if (!$row) {
            throw new \RuntimeException(sprintf(
                'Could not retrieve the row %d', $id
            ));
        }

        return $row;
    }

    public function delete($id){
        $id = (int) $id;
        $this->tableGateway->delete([
            'id' => (int)$id
        ]);
    }
}