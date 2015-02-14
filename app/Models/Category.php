<?php
namespace Models;

class Category extends \RedBean_SimpleModel
{
    const TABLENAME = 'categories';
    const DATE_FORMAT = 'Y-m-d H:i:s'; // SQL formatted date

    public function __construct($id=0)
    {
        if ($id > 0)
        {
        	$this->bean = \R::findOne(self::TABLENAME, 'id = ?', [$id]);
        }
        else
        {
            $this->bean = \R::dispense(self::TABLENAME);
        }
    }

    public static function getList(){
    	return \R::findAll(self::TABLENAME , ' ORDER BY ordering ASC' );
    }

    public function create($name, $ordering=0)
    {
        $errors = array('name' => false);
        $fixes = array();

        if ('' == $name)
        {
            $fixes[] = "All fields are required.";
        }

        if (0 != \R::count(self::TABLENAME, 'name = ?', [$name]))
        {
            $errors['name'] = true;
            $fixes[] = 'That category name is already in use.';
        }
      
        if (0 == count($fixes))
        {
            $date = date(self::DATE_FORMAT);
            $category = $this->bean;

            $category->name = $name;
            $category->ordering = (int)$ordering;            
            $category->created = $date;                        
            
            \R::store($category);
            $this->bean = $category;            
        }

        return array($errors, $fixes);
    }
}