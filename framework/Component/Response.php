<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 06/11/20
 * Time: 20:22
 */

namespace MegatronFrameWork\Component;


class Response
{
    protected $content = "";
    protected $headers = [];
    protected $status;

    public function __construct($content= '', $headers = [], $status = 200)
    {
        $this->content = $content;
        $this->headers = [];
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return Response
     */
    public function setContent(string $content): Response
    {
        $this->content = $content;
        return $this;
    }

    public function send()
    {
        header('Content-Type: text/html');
        echo $this->getContent();
    }



}