<?php 
/**
 * Custom logging to Slack
 * @slimdestro
 */
namespace App\Plugin\DestroLogger;

use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;

class DestroLogger extends AbstractLogger
{
    /**
     * @var string
     */
    private $slackWebhookUrl;

    /**
     * @var string
     */
    private $logLevel;

    /**
     * DestroLogger constructor.
     *
     * @param string $slackWebhookUrl
     * @param string $logLevel
     */
    public function __construct($slackWebhookUrl, $logLevel = LogLevel::INFO)
    {
        $this->slackWebhookUrl = $slackWebhookUrl;
        $this->logLevel = $logLevel;
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed  $level
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function log($level, $message, array $context = array())
    {
        if ($level < $this->logLevel) {
            return;
        }

        $data = array(
            'text' => $message,
            'channel' => '#logs',
            'username' => 'DestroLogger',
            'icon_emoji' => ':ghost:'
        );

        $ch = curl_init($this->slackWebhookUrl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
    }
}

// Usage example
$logger = new DestroLogger('https://hooks.slack.com/services/XXXXXXXXX/XXXXXXXXX/XXXXXXXXXXXXXXXXXXXXXXXX');
$logger->log(LogLevel::INFO, 'This is a test log message');