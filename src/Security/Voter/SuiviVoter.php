<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

use App\Entity\Commande;
use App\Entity\Demande;
use App\Entity\User;

class SuiviVoter extends Voter
{
	const VIEW = 'view';
	const SUPPORTED_ATTRIBUTES = [
		self::VIEW,
	];

	/**
	 * @var EntityManagerInterface
	 */
    private $em;
    
    private $security;

	public function __construct(EntityManagerInterface $em, Security $security)
	{
        $this->em = $em;
        $this->security = $security;
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

        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

		$commande = $subject; 

		return $this->canView($commande, $user);
    }
    
    /**
     * {@inheritdoc}
     */
    private function canView(Commande $commande, User $user)
    {
        return $user === $commande->getClient()->getUser();
    }
}