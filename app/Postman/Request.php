<?php

namespace App\Postman;

use App\Writer\AbstractConvert;

class Request extends AbstractConvert
{
    use CollectionTrait;

    /**
     * @var Auth
     */
    protected $auth;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var Header
     */
    protected $header;

    /**
     * @var Body
     */
    protected $body;

    /**
     * @var Url
     */
    protected $url;

    /**
     * Request constructor.
     * @param array $request
     */
    public function __construct(array $request)
    {
        $this->parseRequest($request);
    }

    /**
     * @param array $request
     */
    protected function parseRequest(array $request): void
    {
        $this->setRaw($request);

        isset($request['auth']) && $this->setAuth($request['auth']);

        $this->setMethod($request['method']);

        $this->setHeader($request['header']);

        $this->setBody($request['body']);

        $this->setUrl($request['url']);

        isset($request['description']) && $this->setDescription($request['description']);
    }

    /**
     * @param array $auth
     */
    protected function setAuth(array $auth): void
    {
        $this->auth = new Auth($auth);
    }

    /**
     * @param string $method
     */
    protected function setMethod(string $method): void
    {
        $this->method = $method;
    }

    /**
     * @param array $header
     */
    protected function setHeader(array $header): void
    {
        $this->header = new Header($header);
    }

    /**
     * @param array $body
     */
    protected function setBody(array $body): void
    {
        $this->body = new Body($body);
    }

    /**
     * @param $url
     */
    protected function setUrl($url): void
    {
        $this->url = new Url($url);
    }

    /**
     * To markdown
     */
    public function toMarkdown(): void
    {
        $markdown = app('markdown');

        !empty($this->description) && $markdown->line($this->description);

        $markdown->h('URL', 5);
        $markdown->code($this->method);
        $this->url->toMarkdown();
        $markdown->enter(2);

        if ($this->header->hasHeader()) {
            $markdown->h('HEADER', 5);
            $this->header->toMarkdown();
            $markdown->enter();
        }

        if ($this->body->hasBody()) {
            $markdown->h('BODY', 5);
            $this->body->toMarkdown();
            $markdown->enter();
        }
    }

    /**
     * Convert to docx.
     */
    public function toDocx(): void
    {
        /**
         * @var \App\Writer\Docx $docx
         */
        $docx = app('docx');
    }
}