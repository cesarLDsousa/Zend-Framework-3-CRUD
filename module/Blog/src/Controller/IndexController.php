<?php 

namespace Blog\Controller;

use Blog\Model\Post;
use Blog\Form\PostForm;
use Blog\Model\PostTable;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;


class IndexController extends AbstractActionController 
{
    private $table;

    public function __construct(PostTable $table)
    {
        $this->table = $table;
    }
    public function indexAction()
    {
        $posts = $this->table->fetchAll();

        return new ViewModel([
            'posts' => $posts
        ]);
    }
    public function addAction()
    {
        $form = new PostForm();
        $form->get('submit')->setValue('CONFIRMAR');

        $request = $this->getRequest();
        //se n for post retorna a view normal
        if (!$request->isPost()) {
            return [
                'form' => $form
            ];
        }

        $post = new Post();
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form];
        }

        $post->exchangeArray($form->getData());

        $this->table->save($post);

        return $this->redirect()->toRoute('post');
    }

    public function editAction()
    {
        $id = (Int) $this->params()->fromRoute('id', 0);

        if ($id === 0 or !$id) {
            return $this->redirect()->toRoute('post');
        }

        try {
            $post = $this->table->find($id);
        } catch(\Exception  $e) {
            return $this->redirect()->toRoute('post');
        }

        $form = new PostForm();
        $form->bind($post); //passando model para o form (preenchendo os campos)
        $form->get('submit')->setAttribute('value', 'CONFIRMAR');

        $request = $this->getRequest();

        if (!$request->isPost()) {
            return new ViewModel([
                'form' => $form,
                'id' => $id
            ]);
        }

        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return new ViewModel([
                'form' => $form,
                'id' => $id
            ]);
        }

        $this->table->save($post);

        return $this->redirect()->toRoute('post');
    }

    public function deleteAction()
    {
        $id = (Int) $this->params()->fromRoute('id', 0);

        if ($id === 0 or !$id) {
            return $this->redirect()->toRoute('post');
        }

        $this->table->delete($id);
        return $this->redirect()->toRoute('post');
    }
    
}