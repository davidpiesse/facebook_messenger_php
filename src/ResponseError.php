<?php
namespace mapdev\FacebookMessenger;

class ResponseError
{
    protected $message;
    protected $type;
    protected $code;
    protected $fbtrace_id;

    /**
     * ResponseError constructor.
     * @param $message
     * @param $type
     * @param $code
     * @param $fbtrace_id
     */
    public function __construct($message, $type, $code, $fbtrace_id)
    {
        $this->message = $message;
        $this->type = $type;
        $this->code = $code;
        $this->fbtrace_id = $fbtrace_id;
    }

    //TODO
    //Add const for potential error for easy understanding
}