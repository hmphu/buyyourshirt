<?php
namespace Models;

class Item extends \RedBean_SimpleModel
{
    const TABLENAME = 'items';
    const DATE_FORMAT = 'Y-m-d H:i:s'; // SQL formatted date

    public function __construct()
    {
        
    }
}