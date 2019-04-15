<?php

/**
 * @Author: stephan
 * @Date:   2019-04-15 11:06:48
 * @Last Modified by:   stephan
 * @Last Modified time: 2019-04-15 12:21:51
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
}