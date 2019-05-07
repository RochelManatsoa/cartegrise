<?php

/**
 * @Author: stephan
 * @Date:   2019-04-18 07:17:12
 * @Last Modified by:   stephan
 * @Last Modified time: 2019-04-18 07:40:17
 */

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Commande;
use App\Entity\Demande;
use App\Entity\User;

class CommandeVoter extends Voter
{
	const PASSER = 'passer';
	const SUPPORTED_ATTRIBUTES = [
		self::PASSER,
	];

	/**
	 * @var EntityManagerInterface
	 */
	private $em;

	public function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
	}

    /**
     * {@inheritdoc}
     */
	public function supports($attribute, $subject): bool
	{
		return ($subject instanceof Commande) && in_array($attribute, self::SUPPORTED_ATTRIBUTES);
	}

	/**
	 * {@inheritdoc}
	 */
	public function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
	{
		$user = $token->getUser();

		if (!$user instanceof User) {
			return false;
		}

		$commande = $subject; // since $subject must be an instance of Commande
		$demandes = $this->em->getRepository(Demande::class)->findByCommande($commande);

		return count($demandes) === 0;
	}
}