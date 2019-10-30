<?php
/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace App\EventListener;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
/**
 * Sends emails for the memory spool.
 *
 * Emails are sent on the kernel.terminate event.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class EmailListener implements EventSubscriberInterface
{
    private $container;
    private $wasExceptionThrown = false;
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    public function onTerminate()
    {
        
        if (!$this->container->has('mailer') || $this->wasExceptionThrown) {
            return;
        }
        dump($this->container);
        
        $mailers = array_keys($this->container->getParameter('swiftmailer.mailers'));
        foreach ($mailers as $name) {
            if (method_exists($this->container, 'initialized') ? $this->container->initialized(sprintf('swiftmailer.mailer.%s', $name)) : true) {
                if ($this->container->getParameter(sprintf('swiftmailer.mailer.%s.spool.enabled', $name))) {
                    $mailer = $this->container->get(sprintf('swiftmailer.mailer.%s', $name));
                    
                    $transport = $mailer->getTransport();
                    dump($transport->isStarted());
                    if ($transport instanceof \Swift_Transport_SpoolTransport) {
                        $spool = $transport->getSpool();
                        if ($spool instanceof \Swift_MemorySpool){
                            // dump($this->container->get(sprintf('swiftmailer.mailer.%s.transport.real', $name)));
                        }
                    }
                }
            }
        }
    }
    public static function getSubscribedEvents()
    {
        $listeners = [
            KernelEvents::EXCEPTION => 'onException',
            KernelEvents::TERMINATE => ['onTerminate', 10],
        ];
        if (class_exists('Symfony\Component\Console\ConsoleEvents')) {
            $listeners[class_exists('Symfony\Component\Console\Event\ConsoleErrorEvent') ? ConsoleEvents::ERROR : ConsoleEvents::EXCEPTION] = 'onException';
            $listeners[ConsoleEvents::TERMINATE] = ['onTerminate', -10];
        }
        return $listeners;
    }
    public function onException()
    {
        $this->wasExceptionThrown = true;
    }
    public function reset()
    {
        $this->wasExceptionThrown = false;
    }
}