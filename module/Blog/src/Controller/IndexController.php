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
        $form->get('submit')->setValue('Add Post');

        $request = $this->getRequest();
        //se n for post retorna a view normal
        if (!$request->isPost()) {
            return new ViewModel([
                'form' => $form
            ]);
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
}