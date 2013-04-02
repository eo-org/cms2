<?php
namespace Ext\Brick;

class SpriteExt
{
	protected $spriteName;
	protected $content;
	
	public function __construct($spriteName, $content)
	{
		$this->spriteName = $spriteName;
		$this->content = $content;
	}
	
	public function getSpriteName()
	{
		return $this->spriteName;
	}
	
	public function render()
	{
		return $this->content;
	}
}