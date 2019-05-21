<?php
/*
 * @Author: Patrick &lt;&lt; rapaelec@gmail.com &gt;&gt; 
 * @Date: 2019-05-13 00:37:24 
 * @Last Modified by: Patrick << rapaelec@gmail.com >>
 * @Last Modified time: 2019-05-21 17:34:41
 */
namespace App\EventListener;

use Doctrine\Common\Annotations\Reader;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use App\Manager\DemandeManager;
use App\Annotation\MailDocumentValidator;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
 
class AnnotationValidator
{
    /**
     * @var Reader
     */
    private $reader;

    private $demandeManager;
    private $tokenStorage;
    private $routerInterface;
 
    /**
     * AnnotationDriver constructor.
     *
     * @param Reader $reader
     */
    public function __construct(
        Reader $reader,
        DemandeManager $demandeManager,
        TokenStorageInterface $tokenStorage,
        RouterInterface $routerInterface
    )
    {
        $this->reader = $reader;
        $this->demandeManager = $demandeManager;
        $this->tokenStorage = $tokenStorage;
        $this->routerInterface = $routerInterface;
    }

    private function retirectRole(FilterControllerEvent $event, $configuration, array $options){
        $role = $options['role'];
        $routeMatch = $options['routeMatch'];
        $defaultRoute = $options['defaultRoute'];
        if ($configuration instanceof Route) {
            if (!$this->tokenStorage->getToken()->getUser() instanceof User) {
                return;
            }
            if ($this->tokenStorage->getToken()->getUser()->hasRole($role)) {
                if (!is_numeric(strpos($configuration->getName(), $routeMatch))) {
                    // redirect to the right way
                    $redirectUrl = $this->routerInterface->generate($defaultRoute);
                    $event->setController(function() use ($redirectUrl) {
                        return new RedirectResponse($redirectUrl);
                    });
                }
            }
        }
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
            $this->retirectRole($event, $configuration,
            [
                "role" => "ROLE_CRM",
                "routeMatch" => "route_crm_",
                "defaultRoute" => "route_crm_home",
            ]);

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