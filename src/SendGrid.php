<?php

namespace Sichikawa\LaravelSendgridDriver;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Sichikawa\LaravelSendgridDriver\Transport\SendgridTransport;
use Swift_Message;

trait SendGrid
{

    /**
     * @param null|array $params
     * @return $this
     */
    public function sendgrid($params)
    {
        if ($this instanceof Mailable && $this->mailDriver() == "sendgrid") {
            $this->withSwiftMessage(function (Swift_Message $message) use ($params) {
                $message->embed(new \Swift_Image(static::sgEncode($params), SendgridTransport::SMTP_API_NAME));

                if (isset($params['logging']) && $params['logging']) {
                    Log::info('sendgrid', [
                        'message_id' => $message->getId(),
                        'message_from' => implode(', ', array_keys($message->getFrom())),
                        'message_to' => implode(', ', array_keys($message->getTo())),
                        'message_subject' => $message->getSubject(),
                    ]);
                }
            });
        }

        return $this;
    }

    /**
     * @return string
     */
    private function mailDriver()
    {
        return function_exists('config') ? config('mail.driver') : env('MAIL_DRIVER');
    }

    /**
     * @param array $params
     * @return string
     */
    public static function sgEncode($params)
    {
        if (is_string($params)) {
            return $params;
        }
        return json_encode($params);
    }

    /**
     * @param string $strParams
     * @return array
     */
    public static function sgDecode($strParams)
    {
        if (!is_string($strParams)) {
            return (array) $strParams;
        }
        $params = json_decode($strParams, true);
        return is_array($params) ? $params : [];
    }

}
