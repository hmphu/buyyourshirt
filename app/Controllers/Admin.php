<?php
namespace Controllers;

class Admin extends BaseController
{    
    protected function initRoutes()
    {        
        $this->app->get('/admin', array($this, 'index'))->name('admin');
        $this->app->get('/admin/category', array($this, 'listCategories'))->name('admin_category');
        $this->app->get('/admin/category/add', array($this, 'showCategoryForm'))->name('admin_category_add');
        $this->app->get('/admin/category/:id', array($this, 'showCategoryForm'))->name('admin_category_edit');
        $this->app->post('/category/post', array($this, 'processPostCategory'));

        $this->app->get('/admin/item', array($this, 'listItems'))->name('admin_item');
        $this->app->get('/admin/item/add', array($this, 'showItemForm'))->name('admin_item_add');
        $this->app->get('/admin/item/:id', array($this, 'showItemForm'))->name('admin_item_edit');
        $this->app->post('/item/post', array($this, 'processPostItem'));
    }    

    public function index()
    {
        $this->verifyLogin();
        $this->app->render('admin/index.twig', array('dashboardIsActive' => true));
    }

    public function listCategories()
    {
        $this->verifyLogin();
        $this->app->render('admin/categories.twig', array('categoryIsActive' => true));
    }

    public function showCategoryForm($id=0)
    {
        $this->verifyLogin();
        $this->app->render('admin/category_form.twig', array('oneIsActive' => true));
    }

    public function processPostCategory()
    {
        $this->verifyLogin();
    }

    public function listItems(){
        $this->verifyLogin();
        $this->app->render('admin/items.twig', array('oneIsActive' => true));
    }

    public function showItemForm($id=0){
        $this->verifyLogin();
        $this->app->render('admin/item_form.twig', array('oneIsActive' => true));
    }

    public function processPostItem(){
        $this->verifyLogin();
    }

}
