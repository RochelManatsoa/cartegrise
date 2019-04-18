<?php

/**
 * @Author: stephan
 * @Date:   2019-04-15 11:06:48
 * @Last Modified by: Patrick << rapaelec@gmail.com >>
 * @Last Modified time: 2019-04-18 18:01:31
 */

namespace App\Services\Tms;

class TmsClient
{
	public function __construct($endpoint, $codeTMS, $login, $password)
	{
		$this->endpoint = $endpoint;
		$this->codeTMS = $codeTMS;
		$this->login = $login;
		$this->password = $password;
	}

	public function envoyer($params)
	{
        $client = new \SoapClient($this->endpoint);

        $identification = [
        	"CodeTMS" => $this->codeTMS,
        	"Login" => $this->login,
        	"Password" => $this->password,
        ];

        $params['Identification'] = $identification;

        return new Response($client->Envoyer($params));
	}

	/**
	 * Info about immatriculation
	 */
	public function infoImmat($Immat)
	{
        $client = new \SoapClient($this->endpoint);
        $identification = [
        	"CodeTMS" => $this->codeTMS,
        	"Login" => $this->login,
        	"Password" => $this->password,
        ];
		$Immat['Identification'] = $identification;

        return new Response($client->InfoImmat($Immat));
	}

	/**
	 * To get Cerfa of commande
	 */
	public function editer($params)
	{
        $client = new \SoapClient($this->endpoint);
        $identification = [
        	"CodeTMS" => $this->codeTMS,
        	"Login" => $this->login,
        	"Password" => $this->password,
        ];
		$params['Identification'] = $identification;

        return new Response($client->Editer($params));
	}
}
