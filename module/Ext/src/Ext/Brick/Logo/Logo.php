<?php
namespace Ext\Brick\Logo;

use Ext\Brick\AbstractExt;

class Logo extends AbstractExt
{
	public function prepare()
    {
    	$dbFactory = $this->dbFactory();
    	
    	$siteDoc = $dbFactory->_m('Info')->fetchOne();
    	$logo = 'none';
    	if(!empty($siteDoc->logo)) {
    		$logo = $siteDoc->logo;
    	}
    	$this->view->logoPath = $logo;
    }
    
    public function getTplList()
    {
    	return array('view' => 'logo\logo\view.tpl');
    }
}