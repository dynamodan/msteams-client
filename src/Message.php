<?php namespace Dynamodan\MSTeams;

use InvalidArgumentException;

class Message {

  /**
   * Reference to the MSTeams client responsible for sending
   * the message
   *
   * @var \Dynamodan\MSTeams\Client
   */
  protected $client;

  /**
   * The text to send with the message
   *
   * @var string
   */
  protected $title;

  /**
   * The text to send with the message
   *
   * @var string
   */
  protected $text;

  /**
   * Instantiate a new Message
   *
   * @param \Dynamodan\MSTeams\Client $client
   * @return void
   */
  public function __construct(Client $client)
  {
    $this->client = $client;
  }

  /**
   * Get the message title
   *
   * @return string
   */
  public function getTitle()
  {
    return $this->title;
  }

  /**
   * Set the message title
   *
   * @param string $title
   * @return $this
   */
  public function setTitle($title)
  {
    $this->title = $title;

    return $this;
  }

  /**
   * Get the message text
   *
   * @return string
   */
  public function getText()
  {
    return $this->text;
  }

  /**
   * Set the message text
   *
   * @param string $text
   * @return $this
   */
  public function setText($text)
  {
    $this->text = $text;

    return $this;
  }

  /**
   * Send the message
   *
   * @param string $text The text to send
   * @return void
   */
  public function send($text = null)
  {
    if ($text) $this->setText($text);

    $this->client->sendMessage($this);
  }

}