<?php
error_reporting( E_ALL | E_STRICT);
ini_set( 'display_errors', 1);


class TempException extends Exception {}


class Temp
{
  protected $path;
  protected $data = array();

  public function __construct($path = 'templates/')
  {
    $this->path = $path;
  }

  public function __get($key)
  {
    if (isset($this->data[$key]))
      return $this->data[$key];
    else
      return null;
  }

  public function __set($key, $value)
  {
    $key = (string) $key;

    if ((null === $value) && isset($this->data[$key])) {
      unset($this->data[$key]);
    } elseif (null !== $value) {
      $this->data[$key] = $value;
    }
  }

  public function includeFile($name)
  {
    if (!file_exists($this->path.$name))
      throw new TempException('Include file '. $name. ' doesn\'t found');

    extract($this->data);

    require_once( $this->path.$name);
  }
}



$temp = new Temp();

$temp->title = 'Hello world!';
$temp->article = array('head' => 'Article', 'content' => 'content of the article');
$temp->comments = array('May-12' => array( 'username' =>'Vitaliy', 'text' => '- Hi all!'),
                'May-13' => array( 'username' => 'Vitaliy','text' => '- Hello all?!'));

try {
  $temp->includeFile("index.tpl.php");
} catch (TempException $e) {
  die('Temp error: '.$e->getMessage());
}