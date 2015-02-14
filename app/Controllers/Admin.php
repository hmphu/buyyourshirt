<?php
namespace Controllers;

class Admin extends BaseController
{    
    protected function initRoutes()
    {        
        $this->app->get('/admin/', array($this, 'index'))->name('admin');
        $this->app->get('/admin/dashboard', array($this, 'dashboard'))->name('admin_dashboard');
        $this->app->get('/admin/category', array($this, 'listCategories'))->name('admin_category');
        $this->app->get('/admin/category/add', array($this, 'showCategoryForm'))->name('admin_category_add');
        $this->app->get('/admin/category/:id', array($this, 'showCategoryForm'))->name('admin_category_edit');
        $this->app->post('/admin/category/add', array($this, 'processPostCategory'));
        $this->app->post('/admin/category/:id', array($this, 'processPostCategory'));

        $this->app->get('/admin/item', array($this, 'listItems'))->name('admin_item');
        $this->app->get('/admin/item/add', array($this, 'showItemForm'))->name('admin_item_add');
        $this->app->get('/admin/item/:id', array($this, 'showItemForm'))->name('admin_item_edit');
        $this->app->post('/admin/item/add', array($this, 'processPostItem'));
        $this->app->post('/admin/item/:id', array($this, 'processPostItem'));        
    }    
    
    public function index()
    {
        $this->app->redirect($this->app->urlFor('admin_dashboard'));        
    }

    public function dashboard()
    {
        $this->verifyLogin();
        $this->app->render('admin/dashboard.twig', array('dashboardIsActive' => true));
    }

    public function listCategories()
    {
        $this->verifyLogin();
        $categories = \Models\Category::getList();
        $this->app->render('admin/category/list.twig', array('categoryIsActive' => true,'categories' => $categories));
    }

    public function showCategoryForm($id=0)
    {
        $this->verifyLogin();
        $formaction = $this->app->request()->getPath();

        if($id != 0){
            $category = new \Models\Category($id);
            $this->app->flashNow('fname', $category->name);
            $this->app->flashNow('fordering', $category->ordering);            
        }
        else{
            $category = null;
        }

        $this->app->render('admin/category/form.twig', array('category' => $category,'formaction'=>$formaction));
    }

    public function processPostCategory($id = 0)
    {
        $this->verifyLogin();

        $req = $this->app->request;
        $category = new \Models\Category($id);
        list($errors, $fixes) = $category->create($req->post('name'), $req->post('ordering'));

        if (0 == count($fixes))
        {
            $this->app->flashNow('created', true);
            $this->app->redirect($this->app->urlFor('admin_category'));
        }
        else
        {
            if (!is_null($req->post('name')))
            {
                $this->app->flashNow('fname', $req->post('name'));
            }

            if (!is_null($req->post('ordering')))
            {
                $this->app->flashNow('fordering', $req->post('ordering'));
            }

            $this->app->flashNow('errors', $errors);
            $this->app->flashNow('fixes', $fixes);
            $formaction = $this->app->request()->getPath();
            $this->app->redirect($formaction);
        }
    }

    public function listItems(){
        $this->verifyLogin();
        $this->app->render('admin/item/list.twig', array('itemIsActive' => true));
    }

    public function showItemForm($id=0){
        $this->verifyLogin();
        $this->app->render('admin/item/form.twig', array('itemIsActive' => true));
    }

    public function processPostItem(){
        $this->verifyLogin();
    }

}
