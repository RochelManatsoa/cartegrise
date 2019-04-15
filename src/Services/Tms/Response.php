<?php

/**
 * @Author: stephan
 * @Date:   2019-04-15 12:17:38
 * @Last Modified by:   stephan
 * @Last Modified time: 2019-04-15 12:27:20
 */

namespace App\Services\Tms;

class Response
{
	/**
	 * @mixed
	 */
	private $rawData;

	public function __construct($tmsResponse)
	{
		$this->rawData = $tmsResponse;
	}

	public function isSuccessfull()
	{
		return !isset($value->Lot->Demarche->ECGAUTO->Reponse->Negative->Erreur);
	}

	public function getRawData()
	{
		return $this->rawData;
	}
}