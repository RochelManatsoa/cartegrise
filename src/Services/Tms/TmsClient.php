<?php

/**
 * @Author: stephan
 * @Date:   2019-04-15 11:06:48
 * @Last Modified by: Patrick << rapaelec@gmail.com >>
 * @Last Modified time: 2019-07-30 08:37:31
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

	public function ouvrir($params)
	{
        $client = new \SoapClient($this->endpoint);

        $identification = [
        	"CodeTMS" => $this->codeTMS,
        	"Login" => $this->login,
        	"Password" => $this->password,
        ];

        $params['Identification'] = $identification;

        return new Response($client->Ouvrir($params));
	}

	public function sauver($params)
	{
        $client = new \SoapClient($this->endpoint);

        $identification = [
        	"CodeTMS" => $this->codeTMS,
        	"Login" => $this->login,
        	"Password" => $this->password,
        ];

        $params['Identification'] = $identification;

        return new Response($client->Sauver($params));
	}

	/**
	 * Info about immatriculation
	 */
	public function infoImmat($Immat)
	{
		try {
			$opts = array(
				'http' => array(
					'user_agent' => 'PHPSoapClient'
				)
			);
			$context = stream_context_create($opts);
			$soapClientOptions = array(
				'stream_context' => $context,
				'cache_wsdl' => WSDL_CACHE_NONE
			);

			$client = new \SoapClient($this->endpoint, $soapClientOptions);

			$identification = [
				"CodeTMS" => $this->codeTMS,
				"Login" => $this->login,
				"Password" => $this->password,
			];
			$Immat['Identification'] = $identification;

			return new Response($client->InfoImmat($Immat));
		}
		catch(Exception $e) {
			echo $e->getMessage();
		}
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
