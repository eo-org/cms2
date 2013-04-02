<?php
namespace Ext\Brick\Search;

use Ext\Brick\AbstractExt;

class Input extends AbstractExt
{
    public function prepare()
    {
    	
    }
    
    public function getTplList()
    {
    	return array('view' => 'search\input\view.tpl');
    }
}