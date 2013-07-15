<?php
namespace Cms\Func;

class TimeStamper
{
	public function stamp($doc)
	{
		$fsa = new \Cms\Session\Admin();
		
		$currentDateTime = new \DateTime();
		if($doc->isNew()) {
			$doc->setCreated($currentDateTime);
			$doc->setCreatedBy($fsa->getRoleId());
			$doc->setCreatedByAlias($fsa->getUserData('loginName'));
		}
		$doc->setModified($currentDateTime);
		$doc->setModifiedBy($fsa->getRoleId());
		$doc->setModifiedByAlias($fsa->getUserData('loginName'));
	}
}