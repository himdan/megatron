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

    public function __construct($content = '', $headers = [], $status = 200)
    {
        $this->content = $content;
        $this->headers = array_merge(
            [
                'Content-Type' => 'text/html',

            ],
            $headers
        );
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

    protected function sendHeaders()
    {
        foreach ($this->headers as $headerKey => $headerValue) {
            header(sprintf('%s:%s', $headerKey, $headerValue));
        }
    }

    protected function sendContent()
    {

        if(function_exists('gzencode')){
            header('Content-Encoding: gzip');
        }
        ob_start();
        echo $this->getContent();
        $content = ob_get_contents();
        ob_end_clean();
        if (function_exists('gzencode')) {
            echo gzencode($content);
        } else {
            echo $content;
        }

    }

    public function send()
    {
        http_response_code($this->getStatus());
        $this->sendHeaders();
        $this->sendContent();
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }


}