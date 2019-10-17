<?php


namespace App\Services;


use App\Helper\LoggerTrait;
use Nexy\Slack\Client;

class SlackClient
{
    use LoggerTrait;

    /**
     * @var Client
     */
    private $slack;

    /**
     * SlackClient constructor.
     * @param Client $slack
     */
    public function __construct(Client $slack)
    {
        $this->slack = $slack;
    }

    public function sendMessage(string $sender, string $messageText)
    {
        $this->logInfo('Hi, there!', [
            'message' => $messageText,
        ]);

        $message = $this->slack->createMessage()
            ->from($sender)
            ->withIcon(':ghost')
            ->setText($messageText);

        $this->slack->sendMessage($message);
    }
}