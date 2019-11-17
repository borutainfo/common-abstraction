<?php declare(strict_types=1);
/**
 * @author Sebastian Boruta <sebastian@boruta.info>
 */

namespace Boruta\CommonAbstraction\Gateway;


/**
 * Interface MailGatewayInterface
 * @package Boruta\CommonAbstraction\Gateway
 */
interface MailGatewayInterface
{
    /**
     * @param string $senderEmail
     * @param string $senderName
     * @param string $subject
     * @param string $messageHtml
     * @param array $receivers
     * @return bool
     */
    public function send(
        string $senderEmail,
        string $senderName,
        string $subject,
        string $messageHtml,
        array $receivers
    ): bool;
}
