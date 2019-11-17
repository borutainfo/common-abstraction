<?php declare(strict_types=1);
/**
 * @author Sebastian Boruta <sebastian@boruta.info>
 */

namespace Boruta\CommonAbstraction\Gateway;


use Boruta\CommonAbstraction\Config\MailConfig;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * Class MailGateway
 * @package Boruta\CommonAbstraction\Gateway
 */
class MailGateway implements MailGatewayInterface
{
    /**
     * @var PHPMailer
     */
    private $mailer;
    /**
     * @var MailConfig
     */
    private $config;

    /**
     * MailGateway constructor.
     * @param PHPMailer $mailer
     * @param MailConfig $config
     */
    public function __construct(PHPMailer $mailer, MailConfig $config)
    {
        $this->mailer = $mailer;
        $this->config = $config;
    }

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
    ): bool {
        try {
            $mailer = clone $this->mailer;
            $mailer->isSMTP();
            $mailer->SMTPAuth = $this->config->getSmtpAuth();
            $mailer->Host = $this->config->getHost();
            $mailer->Port = $this->config->getPort();
            $mailer->Username = $this->config->getLogin();
            $mailer->Password = $this->config->getPassword();

            $mailer->setFrom($senderEmail, $senderName);
            $mailer->Subject = $subject;
            $mailer->msgHTML($messageHtml);

            foreach ($receivers as $receiver) {
                $mailer->addAddress($receiver);
            }

            return $mailer->send();
        } catch (Exception $ignored) {
            return false;
        }
    }
}
