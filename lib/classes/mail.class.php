<?php
    class mail extends serene_object
    {
    	private $to;
    	private $from;
    	private $reply_to;
    	private $return_path;
    	private $header;
    	private $subject;
    	private $message;

    	function __construct($to)
    	{
    		$this->to = $to;
        }
        
        function set_from($address)
        {
        	$this->from = "From: $address\r\n";
        	$this->reply_to = "Reply-To: $address\r\n";
    		$this->return_path = "Return-Path: $address\r\n";
        }

        function set_subject($subject)
        {
        	$this->subject = $subject;
        }

        function set_message($message)
        {
        	$this->message = $message;
        }

        function send()
        {
        	$this->header = $this->from . $this->reply_to . $this->return_path;
        	mail($this->to, $this->subject, $this->message, $this->header);
        }
    }
?>