<?php
/*
 * @Author: Patrick &lt;&lt; rapaelec@gmail.com &gt;&gt; 
 * @Date: 2019-05-13 00:37:24 
 * @Last Modified by:   Patrick &lt;&lt; rapaelec@gmail.com &gt;&gt; 
 * @Last Modified time: 2019-05-13 00:37:24 
 */
namespace App\EventListener;

use Doctrine\Common\Annotations\Reader;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use App\Manager\DemandeManager;
use App\Annotation\MailDocumentValidator;
use Symfony\Component\PropertyAccess\PropertyAccess;
 
class AnnotationValidator
{
    /**
     * @var Reader
     */
    private $reader;

    private $demandeManager;
 
    /**
     * AnnotationDriver constructor.
     *
     * @param Reader $reader
     */
    public function __construct(
        Reader $reader,
        DemandeManager $demandeManager
    )
    {
        $this->reader = $reader;
        $this->demandeManager = $demandeManager;
    }
 
    /**
     * @param FilterControllerEvent $event
     *
     * @throws \Exception
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        if (!is_array($controller = $event->getController())) {
            return;
        }
 
        $object = new \ReflectionObject($controller[0]);
        $method = $object->getMethod($controller[1]);
 
        foreach ($this->reader->getMethodAnnotations($method) as $configuration) {
            if ($configuration instanceof MailDocumentValidator) {
                $request = $event->getRequest();
                $valueProperty = $request->get($configuration->property);
                $valueEntity = $request->get($configuration->entity);
                // check if value is present
                if (!$valueProperty) {
                    continue;
                }
                $manager = $this->getManager($configuration->entity);
                $entity = $manager->find($request->get($configuration->entity));
                $propertyAccessor = PropertyAccess::createPropertyAccessor();
                $valueInEntity = $propertyAccessor->getValue($entity, $configuration->property);
                // check if value is valid
                if ($valueInEntity === $valueProperty) {
                    continue;
                }

                if ($configuration->invalidMessage) {
                    Throw new \Exception($propertyAccessor->getValue($entity, $configuration->invalidMessage));
                }
                // to have an custom error message , please fill the parameter "invalidMessage" in annotation
                Throw new \Exception("error");
            }
        }
    }

    private function getManager($entityName)
    {
        switch ($entityName) {
            case "demande":
                return $this->demandeManager;
                break;
            default:
                return null;
                break;
        }
    }
}