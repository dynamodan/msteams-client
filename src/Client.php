<?php namespace Dynamodan\MSTeams;

use GuzzleHttp\Client as Guzzle;

class Client {

  /**
   * The MSTeams incoming webhook endpoint
   *
   * @var string
   */
  protected $endpoint;

  /**
   * The Guzzle HTTP client instance
   *
   * @var \GuzzleHttp\Client
   */
  protected $guzzle;

  /**
   * Instantiate a new Client
   *
   * @param string $endpoint
   * @param array $attributes
   * @return void
   */
  public function __construct($endpoint, array $attributes = [], Guzzle $guzzle = null) {
    $this->endpoint = $endpoint;

    $this->guzzle = $guzzle ?: new Guzzle;
  }

  /**
   * Pass any unhandled methods through to a new Message
   * instance
   *
   * @param string $name The name of the method
   * @param array $arguments The method arguments
   * @return \Dynamodan\MSTeams\Message
   */
  public function __call($name, $arguments)
  {
    $message = $this->createMessage();

    call_user_func_array([$message, $name], $arguments);

    return $message;
  }

  /**
   * Get the MSTeams endpoint
   *
   * @return string
   */
  public function getEndpoint()
  {
    return $this->endpoint;
  }

  /**
   * Set the MSTeams endpoint
   *
   * @param string $endpoint
   * @return void
   */
  public function setEndpoint($endpoint)
  {
    $this->endpoint = $endpoint;
  }

  /**
   * Create a new message with defaults
   *
   * @return \Dynamodan\MSTeams\Message
   */
  public function createMessage()
  {
    $message = new Message($this);

    // Set some attributes about this message (TODO)
    
    return $message;
  }

  /**
   * Send a message
   *
   * @param \Dynamodan\MSTeams\Message $message
   * @return void
   */
  public function sendMessage(Message $message)
  {
    $payload = $this->preparePayload($message);

    $encoded = json_encode($payload, JSON_UNESCAPED_UNICODE);

    $this->guzzle->post($this->endpoint, ['body' => $encoded]);
  }

  /**
   * Prepares the payload to be sent to the webhook
   *
   * @param \Dynamodan\MSTeams\Message $message The message to send
   * @return array
   */
  public function preparePayload(Message $message)
  {
    $payload = [
		
    	// TODO: lots of attributes to set!
    	'@context' => 'http://schema.org/extensions',
		'@type' => 'MessageCard',
		'themeColor' => '0072C6', // ... and so forth
		
		// Just the basics for now:
    	'text' => $message->getText(),
    ];
    
    if(!is_null($message->getTitle())) { $payload['title'] = $message->getTitle(); }

    return $payload;
  }

}
