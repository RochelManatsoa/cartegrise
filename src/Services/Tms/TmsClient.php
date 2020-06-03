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
		$client = $this->connect();

        $identification = [
        	"CodeTMS" => $this->codeTMS,
        	"Login" => $this->login,
        	"Password" => $this->password,
        ];

        $params['Identification'] = $identification;

        return new Response($client->Envoyer($params));
	}

	private function connect() {
		try {
			$options = [
				'cache_wsdl'     => WSDL_CACHE_NONE,
				'trace'          => 1,
				'stream_context' => stream_context_create(
					[
						'ssl' => [
							'verify_peer'       => false,
							'verify_peer_name'  => false,
							'allow_self_signed' => true
						]
					]
				)
			];

			$client = new \SoapClient($this->endpoint, $options);

			return $client;
		}
		catch(Exception $e) {
			echo $e->getMessage();die;
		}
	}

	public function ouvrir($params)
	{
        $client = $this->connect();

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
        $client = $this->connect();

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
		$client = $this->connect();

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
        $client = $this->connect();
        $identification = [
        	"CodeTMS" => $this->codeTMS,
        	"Login" => $this->login,
        	"Password" => $this->password,
        ];
		$params['Identification'] = $identification;

        return new Response($client->Editer($params));
	}
}
