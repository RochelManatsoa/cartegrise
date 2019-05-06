<?php

namespace App\Manager;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Demande;
use App\Entity\File\DemandeDuplicata;
use App\Form\DocumentDemande\DemandeDuplicataType;

class DocumentAFournirManager
{
    private $entityManager;
    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function getDaf(Demande $demande)
    {
        switch($demande->getCommande()->getDemarche()->getType()) {
            case "DUP":
                return $this->getFileDup($demande);
                break;
            default:
                return null;
                break;
        }
    }

    public function getType(Demande $demande)
    {
        switch($demande->getCommande()->getDemarche()->getType()) {
            case "DUP":
                return DemandeDuplicataType::class;
                break;
            default:
                return null;
                break;
        }
    }

    public function getFileDup(Demande $demande) {
        if ($demande->getDuplicata()->getFile() == null ) {
            $fileDemandeDuplicata = new DemandeDuplicata();
            $demande->getDuplicata()->setFile($fileDemandeDuplicata);
            $this->entityManager->persist($demande);
            $this->entityManager->flush();
        }

        return $demande->getDuplicata()->getFile();
    }

    public function handleForm($form, $path)
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        $data = $form->getData();
        $uow = $this->entityManager->getUnitOfWork();
        $oldData = $uow->getOriginalEntityData($data);
        foreach ($form as $value) {
            $file = $value->getData();
            $fineName = $value->getName();
            if (!null == $file){
                $extension = $file->guessExtension();
                $realName = $fineName.'.'.$extension;
                $link = $path.'/'.$realName;
                $file->move($path, $link);
                $propertyAccessor->setValue($data, $fineName, $link);
            } elseif(isset($oldData[$fineName]) && $oldData[$fineName] != null) {
                $propertyAccessor->setValue($data, $fineName, $oldData[$fineName]);
            }
        }

        return $this;
    }

    public function checkFile($entity, $name)
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        if ($propertyAccessor->isReadable($entity, $name))
        {
            if ($propertyAccessor->getValue($entity, $name) != null)
            {
                return $propertyAccessor->getValue($entity, $name);
            }
        }

        return ""; 
    }

    public function save($form)
    {
        $data = $form->getData();
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }
}