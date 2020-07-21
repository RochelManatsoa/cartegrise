<?php

/**
 * @Author: patrick
 * @Date:   2019-04-15 11:46:01
 * @Last Modified by: Patrick << rapaelec@gmail.com >>
 * @Last Modified time: 2019-12-30 19:19:01
 */

namespace App\Manager;

use Doctrine\ORM\EntityManagerInterface;

use App\Services\Tms\TmsClient;
use App\Services\Tms\Response as ResponseTms;
use App\Entity\{Commande, Demande, Facture, DailyFacture, Avoir, Transaction, Client, User, PreviewEmail};
use App\Entity\GesteCommercial\GesteCommercial;
use App\Repository\{CommandeRepository, DailyFactureRepository, PreviewEmailRepository};
use App\Manager\SessionManager;
use App\Manager\{StatusManager, TMSSauverManager, TransactionManager, TaxesManager, MailManager};
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use App\Entity\Systempay\Transaction as SystempayTransaction;
use Twig_Environment as Twig;

class PreviewEmailManager
{
	public function __construct(
		TmsClient $tmsClient, 
		EntityManagerInterface $em, 
		SessionManager $sessionManager,
        Twig $twig,
        PreviewEmailRepository $repository,
        TaxesManager $taxesManager,
        DailyFactureRepository $dailyFactureRepository,
		StatusManager $statusManager,
		TokenStorageInterface $tokenStorage,
		DocumentTmsManager $documentTmsManager,
		SerializerInterface $serializer,
		TMSSauverManager $tmsSaveManager, 
		TransactionManager $transactionManager,
		MailManager $mailManager
	)
	{
		$this->tmsClient = $tmsClient;
		$this->em = $em;
		$this->repository = $repository;
		$this->taxesManager = $taxesManager;
		$this->dailyFactureRepository = $dailyFactureRepository;
		$this->sessionManager = $sessionManager;
		$this->statusManager = $statusManager;
		$this->tokenStorage = $tokenStorage;
		$this->documentTmsManager = $documentTmsManager;
		$this->serializer = $serializer;
        $this->twig = $twig;
		$this->tmsSaveManager = $tmsSaveManager;
		$this->transactionManager = $transactionManager;
		$this->mailManager = $mailManager;
	}

	public function getPreviewEmailRelanceDemarche()
	{
		return $this->repository->getPreviewEmailRelanceDemarche();
	}
	public function getPreviewEmailRelancePaiement()
	{
		return $this->repository->getPreviewEmailRelancePaiement();
	}
	public function getPreviewEmailRelanceForm()
	{
		return $this->repository->getPreviewEmailRelanceForm();
	}

	public function save(PreviewEmail $previewEmail)
	{
		$this->em->persist($previewEmail);
		$this->em->flush();
	}

	

}
