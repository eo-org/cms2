<?php
namespace Location\Document;

use Core\AbstractDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(
 * 		collection="location_location"
 * )
 *
 * */
class Location extends AbstractDocument
{
	/** @ODM\Id */
	protected $id;

	/** @ODM\Field(type="string")  */
	protected $label;
	
	/** @ODM\Field(type="string")  */
	protected $tel;
	
	/** @ODM\Field(type="string")  */
	protected $provinceName;
	
	/** @ODM\Field(type="string")  */
	protected $cityName;
	
	/** @ODM\Field(type="string")  */
	protected $countyName;
	
	/** @ODM\Field(type="string")  */
	protected $provinceId;

	/** @ODM\Field(type="string")  */
	protected $cityId;

	/** @ODM\Field(type="string")  */
	protected $countyId;

	/** @ODM\Field(type="string")  */
	protected $addressDetail;

	/** @ODM\Field(type="string")  */
	protected $latlon;

	/** @ODM\Field(type="string")  */
	protected $fullAddress;
	
	public function exchangeArray($data)
	{
		$this->label = $data['label'];
		$this->tel = $data['tel'];
		$this->provinceName = $data['provinceName'];
		$this->cityName = $data['cityName'];
		$this->countyName = $data['countyName'];
		$this->provinceId = $data['provinceId'];
		$this->cityId = $data['cityId'];
		$this->countyId = $data['countyId'];
		$this->addressDetail = $data['addressDetail'];
		$this->latlon = $data['latlon'];
		$this->fullAddress = $data['fullAddress'];
	}

	public function getArrayCopy()
	{
		return array(
			'id' => $this->id,
			'label' => $this->label,
			'tel' => $this->tel,
			'provinceName' => $this->provinceName,
			'cityName' => $this->cityName,
			'countyName' => $this->countyName,
			'provinceId' => $this->provinceId,
			'cityId' => $this->cityId,
			'countyId' => $this->countyId,
			'addressDetail' => $this->addressDetail,
			'latlon' => $this->latlon,
			'fullAddress' => $this->fullAddress,
		);
	}
}