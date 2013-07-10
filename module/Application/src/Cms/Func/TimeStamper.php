<?php
namespace Cms\Func;

class TimeStamper
{
	public function stamp($doc)
	{
		$currentDateTime = new \DateTime();
		if($doc->isNew()) {
			$doc->setCreated($currentDateTime);
		}
		$doc->setModified($currentDateTime);
	}
}