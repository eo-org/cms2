<?php
namespace Ext\Brick;

use Ext\Brick\AbstractExt;

class Attachment extends AbstractExt
{
	public function prepare()
    {
    	$layoutFront = $this->getLayoutFront();
    	$resDoc = $layoutFront->getContext()->getResourceDoc();
    	if(is_null($resDoc) || !is_object($resDoc)) {
    		$attachment = null;
    	} else {
    		$attachment = $resDoc->attachment;
    	}
    	
    	$download = array();
    	if(is_null($attachment) || count($attachment) == 0) {
    		$this->_disableRender = true;
    	} else {
    		foreach($attachment as $atta) {
    			if($atta['filetype'] == 'download') {
    				$download[] = $atta;
    			}
    		}
    	}
    	
    	if(count($download) == 0) {
    		$this->_disableRender = true;
    	}
    	$this->view->download = $download;
    }
    
    public function getTplList()
    {
    	return array('view' => 'attachment/view.tpl');
    }
}