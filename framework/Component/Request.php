<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 06/11/20
 * Time: 13:15
 */

namespace MegatronFrameWork\Component;


class Request
{
    const GET = 'get';
    const POST = 'post';
    const PUT = 'put';
    const DELETE = 'delete';
    protected $path = '/';
    protected  $query = [];
    protected $post = [];
    protected $get = [];
    protected  $files = [];
    protected $method;
    protected $host;
    protected $scheme;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->initialize();

    }

    public static  function createFromGlobal()
    {
        return new Request();
    }

    protected function initialize()
    {
        $this->path = $this->parsePath($_SERVER['REQUEST_URI']??'/');
        $this->host = $_SERVER['HTTP_HOST'];
        $this->scheme = $_SERVER['REQUEST_SCHEME'];
        $this->method = strtolower($_SERVER['REQUEST_METHOD'])??'get';
        $this->query = filter_input_array(INPUT_GET, $_GET);
        $this->get = filter_input_array(INPUT_GET, $_GET);
        $this->files = $_FILES;
        if($this->method === self::POST) $this->post = filter_input_array(INPUT_POST, $_POST);

    }

    protected function parsePath($path)
    {
        $position = strpos($path, '?');
        if($position === false) return $path;
        return substr($path, 0,$position);
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    public function get($key, $default = null){
        return $this->get[$key]??$default;
    }

    public function getRequest($key, $default = null)
    {
        return $this->post[$key]??$default;
    }

    public function getContent()
    {
        return file_get_contents('php://input');
    }

    /**
     * @return mixed
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @return mixed
     */
    public function getScheme()
    {
        return $this->scheme;
    }

    public function getBaseUrl()
    {
        return sprintf('%s://%s', $this->getScheme(), $this->getHost());

    }









}