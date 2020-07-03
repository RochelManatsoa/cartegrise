<?php

/**
 * @Author: stephan
 * @Date:   2019-04-15 11:06:48
 * @Last Modified by: Patrick << rapaelec@gmail.com >>
 * @Last Modified time: 2019-07-30 08:37:31
 */

namespace App\Services\Tms;

use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use App\Entity\User;

class TmsClient
{
	public function __construct($endpoint, $codeTMS, $login, $password, LoggerInterface $tmsLogger, TokenStorageInterface $tokenStorage)
	{
		$this->endpoint = $endpoint;
		$this->codeTMS = $codeTMS;
		$this->login = $login;
		$this->password = $password;
		$this->tmsLogger = $tmsLogger;
		$this->tokenStorage = $tokenStorage;
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

	public function envoyer($params)
	{
		$client = $this->connect();

        $identification = [
        	"CodeTMS" => $this->codeTMS,
        	"Login" => $this->login,
        	"Password" => $this->password,
        ];

        $this->log("parametres", \json_encode($params));
		$params['Identification'] = $identification;
		$this->log("user infos", $this->getUserInfos());
		$this->log("appel vers TMS ... ", '...');
		$response = $client->Envoyer($params);
		$this->log("response Envoyer", \json_encode($response), true);

        return new Response($response);
	}


	public function ouvrir($params)
	{
        $client = $this->connect();

        $identification = [
        	"CodeTMS" => $this->codeTMS,
        	"Login" => $this->login,
        	"Password" => $this->password,
        ];
		
		$this->log("parametres", \json_encode($params));
		$params['Identification'] = $identification;
		$this->log("user infos", $this->getUserInfos());
		$this->log("appel vers TMS ... ", '...');
		$response = $client->Ouvrir($params);
		$this->log("response Ouvrir", \json_encode($response), true);

        return new Response($response);
	}

	public function sauver($params)
	{
        $client = $this->connect();

        $identification = [
        	"CodeTMS" => $this->codeTMS,
        	"Login" => $this->login,
        	"Password" => $this->password,
        ];

		

		$this->log("parametres", \json_encode($params));
		$params['Identification'] = $identification;
		$this->log("user infos", $this->getUserInfos());
		$this->log("appel vers TMS ... ", '...');
		$response = $client->Sauver($params);
		$this->log("response Sauver", \json_encode($response), true);

        return new Response($response);
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
			
			$this->log("parametres", \json_encode($Immat));
			$Immat['Identification'] = $identification;
			$this->log("user infos", $this->getUserInfos());
			$this->log("appel vers TMS ... ", '...');
			$response = $client->InfoImmat($Immat);
			$this->log("response InfoImmat", \json_encode($response), true);

			return new Response($response);
	}

	private function getUserInfos()
	{
		// all infos of user is exist
		$user = $this->tokenStorage->getToken()->getUser();
		if ($user instanceof User) {
			$email = $user->getEmail();
		} else {
			$email = 'non connecter';
		}
		return $email;
	}

	private function log($key,$message, $end = false) {
		$this->tmsLogger->info("=======================");
		$this->tmsLogger->info($key ." : ");
		$this->tmsLogger->info($message);
		if ($end) {
			$this->tmsLogger->notice("=======================");
			$this->tmsLogger->notice("=======================");
		}
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
		
		$this->log("parametres", \json_encode($Immat));
		$params['Identification'] = $identification;
		$this->log("user infos", $this->getUserInfos());
		$this->log("appel vers TMS ... ", '...');
		$response = $client->Editer($Immat);
		$this->log("response Editer", \json_encode($response), true);

        return new Response($response);
	}
}
