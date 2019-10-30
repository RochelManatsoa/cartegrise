<?php

namespace App\Modele;

class Swift_Mailer
{
    /** The Transport used to send messages */
    private $transport;

    /**
     * Create a new Mailer using $transport for delivery.
     */
    public function __construct(\Swift_Transport $transport)
    {
        $this->transport = $transport;
    }

    /**
     * Create a new class instance of one of the message services.
     *
     * For example 'mimepart' would create a 'message.mimepart' instance
     *
     * @param string $service
     *
     * @return object
     */
    public function createMessage($service = 'message')
    {
        return \Swift_DependencyContainer::getInstance()
            ->lookup('message.'.$service);
    }

    /**
     * Send the given Message like it would be sent in a mail client.
     *
     * All recipients (with the exception of Bcc) will be able to see the other
     * recipients this message was sent to.
     *
     * Recipient/sender data will be retrieved from the Message object.
     *
     * The return value is the number of recipients who were accepted for
     * delivery.
     *
     * @param array $failedRecipients An array of failures by-reference
     *
     * @return int The number of successful recipients. Can be 0 which indicates failure
     */
    public function send(\Swift_Mime_SimpleMessage $message, &$failedRecipients = null)
    {
        foreach($message->getHeaders()->getAll("To") as $swiftHeader)
        {
            $tos = $swiftHeader->getNameAddresses();
            $emailTo = [];
            foreach($tos as $key=>$to){
                $emailTo []= $key;
            }
        }
        foreach($message->getHeaders()->getAll("From") as $swiftHeader)
        {
            $froms = $swiftHeader->getNameAddresses();
            $emailFrom = [];
            foreach($froms as $key=>$from){
                $emailFrom []= $key;
            }
        }
        // dump($emailTo, $emailFrom);
        dump($message->getBody());die;
        
        $failedRecipients = (array) $failedRecipients;

        // FIXME: to be removed in 7.0 (as transport must now start itself on send)
        if (!$this->transport->isStarted()) {
            $this->transport->start();
        }

        $sent = 0;

        try {
            $sent = $this->transport->send($message, $failedRecipients);
        } catch (\Swift_RfcComplianceException $e) {
            foreach ($message->getTo() as $address => $name) {
                $failedRecipients[] = $address;
            }
        }

        return $sent;
    }

    /**
     * Register a plugin using a known unique key (e.g. myPlugin).
     */
    public function registerPlugin(\Swift_Events_EventListener $plugin)
    {
        $this->transport->registerPlugin($plugin);
    }

    /**
     * The Transport used to send messages.
     *
     * @return \Swift_Transport
     */
    public function getTransport()
    {
        return $this->transport;
    }
}
