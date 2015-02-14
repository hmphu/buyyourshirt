<?php
namespace Models;

class Category extends \RedBean_SimpleModel
{
    const TABLENAME = 'categories';
    const DATE_FORMAT = 'Y-m-d H:i:s'; // SQL formatted date

    public function __construct()
    {
        
    }
}