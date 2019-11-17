<?php declare(strict_types=1);
/**
 * @author Sebastian Boruta <sebastian@boruta.info>
 */

namespace Boruta\CommonAbstraction\Entity;


use Boruta\CommonAbstraction\Collection\EmailAddressCollection;
use Boruta\CommonAbstraction\ValueObject\EmailAddress;
use Boruta\CommonAbstraction\ValueObject\RawString;

/**
 * Class MailMessageEntity
 * @package Boruta\CommonAbstraction\Entity
 */
class MailMessageEntity
{
    /**
     * @var EmailAddress
     */
    protected $senderAddress;
    /**
     * @var RawString
     */
    protected $senderName;
    /**
     * @var RawString
     */
    protected $subject;
    /**
     * @var RawString
     */
    protected $messageHtml;
    /**
     * @var EmailAddressCollection
     */
    protected $receivers;

    /**
     * @return EmailAddress
     */
    public function getSenderAddress(): EmailAddress
    {
        return $this->senderAddress;
    }

    /**
     * @param EmailAddress $senderAddress
     */
    public function setSenderAddress(EmailAddress $senderAddress): void
    {
        $this->senderAddress = $senderAddress;
    }

    /**
     * @return RawString
     */
    public function getSenderName(): RawString
    {
        return $this->senderName;
    }

    /**
     * @param RawString $senderName
     */
    public function setSenderName(RawString $senderName): void
    {
        $this->senderName = $senderName;
    }

    /**
     * @return RawString
     */
    public function getSubject(): RawString
    {
        return $this->subject;
    }

    /**
     * @param RawString $subject
     */
    public function setSubject(RawString $subject): void
    {
        $this->subject = $subject;
    }

    /**
     * @return RawString
     */
    public function getMessageHtml(): RawString
    {
        return $this->messageHtml;
    }

    /**
     * @param RawString $messageHtml
     */
    public function setMessageHtml(RawString $messageHtml): void
    {
        $this->messageHtml = $messageHtml;
    }

    /**
     * @return EmailAddressCollection
     */
    public function getReceivers(): EmailAddressCollection
    {
        return $this->receivers;
    }

    /**
     * @param EmailAddressCollection $receivers
     */
    public function setReceivers(EmailAddressCollection $receivers): void
    {
        $this->receivers = $receivers;
    }
}
