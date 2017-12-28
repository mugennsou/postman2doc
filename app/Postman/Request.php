<?php

namespace App\Postman;

use App\Markdown\Markdownable;

class Request extends AbstractCollection implements Markdownable
{
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
     * @return string
     */
    public function toMarkdown(): string
    {
        $writer = app('writer');

        !empty($this->description) && $writer->line($this->description);

        $writer->h('URL', 5);
        $writer->code($this->method);
        $writer->word($this->url->toMarkdown());
        $writer->enter(2);

        if ($this->header->hasHeader()) {
            $writer->h('HEADER', 5);
            $writer->word($this->header->toMarkdown());
            $writer->enter();
        }

        if ($this->body->hasBody()) {
            $writer->h('BODY', 5);
            $writer->word($this->body->toMarkdown());
            $writer->enter();
        }

        return $writer->toString();
    }
}