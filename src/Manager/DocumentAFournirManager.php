<?php

namespace App\Manager;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Demande;
use App\Manager\Model\ParamDocumentAFournir;
use App\Entity\File\{DemandeDuplicata, DemandeIvn, DemandeCtvo, DemandeCession, DemandeChangementAdresse};
use App\Form\DocumentDemande\{DemandeDuplicataType, DemandeCtvoType, DemandeIvnType, DemandeCessionType, DemandeChangementAdresseType};

class DocumentAFournirManager
{
    private $entityManager;
    private $serializer;
    public function __construct(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer
    )
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    public function getDaf(Demande $demande)
    {
        switch($demande->getCommande()->getDemarche()->getType()) {
            case "DUP":
                return  $this->getFileDup($demande);
                break;
            case "CTVO":
                return  $this->getFileCtvo($demande);
                break;
            case "DIVN":
                return  $this->getFileDivn($demande);
                break;
            case "DC":
                return  $this->getFileDc($demande);
                break;
            case "DCA":
                return  $this->getFileDca($demande);
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
            case "CTVO":
                return DemandeCtvoType::class;
                break;
            case "DIVN":
                return DemandeIvnType::class;
                break;
            case "DC":
                return DemandeCessionType::class;
                break;
            case "DCA":
                return DemandeChangementAdresseType::class;
                break;
            default:
                return null;
                break;
        }
    }

    public function getFileDca(Demande $demande) {
        if ($demande->getChangementAdresse()->getFile() == null ) {
            $fileCession = new DemandeChangementAdresse();
            $demande->getChangementAdresse()->setFile($fileCession);
            $this->entityManager->persist($demande);
            $this->entityManager->flush();
        }

        return $demande->getChangementAdresse()->getFile();
    }

    public function getFileDc(Demande $demande) {
        if ($demande->getCession()->getFile() == null ) {
            $fileCession = new DemandeCession();
            $demande->getCession()->setFile($fileCession);
            $this->entityManager->persist($demande);
            $this->entityManager->flush();
        }

        return $demande->getCession()->getFile();
    }

    public function getFileDivn(Demande $demande) {
        if ($demande->getDivn()->getFile() == null ) {
            $fileDivn = new DemandeIvn();
            $demande->getDivn()->setFile($fileDivn);
            $this->entityManager->persist($demande);
            $this->entityManager->flush();
        }

        return $demande->getDivn()->getFile();
    }

    public function getFileCtvo(Demande $demande) {
        if ($demande->getCtvo()->getFile() == null ) {
            $fileCtvo = new DemandeCtvo();
            $demande->getCtvo()->setFile($fileCtvo);
            $this->entityManager->persist($demande);
            $this->entityManager->flush();
        }

        return $demande->getCtvo()->getFile();
    }

    public function getFileDup(Demande $demande) {
        if ($demande->getDuplicata()){
            if ($demande->getDuplicata()->getFile() == null ) {
                $fileDemandeDuplicata = new DemandeDuplicata();
                $demande->getDuplicata()->setFile($fileDemandeDuplicata);
                $this->entityManager->persist($demande);
                $this->entityManager->flush();
            }
        } else {
            return null;
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

    public function getFilesList(Demande $demande)
    {
        $daf = $this->getDaf($demande);
        $paramDaf = new ParamDocumentAFournir();
        $paramDaf->setName($demande->getCommande()->getDemarche()->getNom())
        ->setDocuments($this->serializer->normalize($daf, 'json', ['groups'=>'file']));

        return $paramDaf;
    }
}