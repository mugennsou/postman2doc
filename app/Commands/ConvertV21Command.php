<?php

namespace App\Commands;

use App\Commands\Traits\PostmanCollectionFile;
use App\Commands\Traits\WriteMarkdown;
use LaravelZero\Framework\Commands\Command;

class ConvertV21Command extends Command
{
    use PostmanCollectionFile,
        WriteMarkdown;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert21
                                    {file : The postman collection version 2.1.0 filename}
                                    {output : Output file name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert postman collection to markdown.';

    /**
     * @var string
     */
    protected $version = 'v2.1.0';

    /**
     * @var array
     */
    protected $headerTitle = ['key', 'value', 'description'];

    /**
     * @var array
     */
    protected $bodyTitle = ['key', 'type', 'value', 'description'];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): void
    {
        $file = $this->argument('file');

        if ($this->getFileVersion($file) !== $this->version)
            $this->error('This postman collection is not version 2.1.0');

        $item = $this->getFileContent($file)['item'];

        $this->openFile();

        $this->parseInfo($this->getFileContent($file)['info']);
        $this->writeEnter();
        $this->parseContents($item);
        $this->writeEnter();
        $this->parseItem($item);

        $this->closeFile();
    }

    /**
     * @param array $info
     */
    protected function parseInfo(array $info): void
    {
        $title       = $info['name'];
        $description = $info['description'] ?? '';

        $this->writeH($title);
        $this->writeLine($description);
    }

    protected function parseContents(array $items, int $key = null)
    {
        $key || $this->writeH('Contents', 2);

        foreach ($items as $itemKey => $item) {
            $h = isset($item['item']) ? 3 : 4;

            $index = ($key ? "{$key}." : '') . ($itemKey + 1);
            $this->writeAnchorLink($item['name'], $index, $h);

            isset($item['item']) && $this->parseContents($item['item'], $itemKey + 1);
        }
    }

    protected function parseItem(array $items): void
    {
        $this->writeH('Body', 2);

        foreach ($items as $key => $item) {
            if (isset($item['item']))
                $this->parseFolderItem($item, $key + 1);

            elseif (isset($item['request']))
                $this->parseRequestItem($item, $key + 1);
        }
    }

    protected function parseFolderItem(array $folder, int $key): void
    {
        $title       = "{$key} {$folder['name']}";
        $description = $folder['description'] ?? '';

        $this->writeAnchor($title, $key, 3);
        $this->writeLine($description);

        if (isset($folder['item']))
            foreach ($folder['item'] as $requestKey => $request) {
                $requestKey++;
                $this->parseRequestItem($request, $requestKey, $key);
            }

        $this->writeEnter();
    }

    protected function parseRequestItem(array $item, int $key, int $folderKey = null): void
    {
        $index       = ($folderKey ? "{$folderKey}." : '') . "{$key}";
        $title       = "{$index} {$item['name']}";
        $description = $item['request']['description'] ?? '';

        $this->writeAnchor($title, $index, 4);
        $this->writeLine($description);

        //Request
        $this->parseRequest($item['request']);

        $this->writeEnter();
    }

    protected function parseRequest(array $request): void
    {
        //Url
        $this->parseUrl($request['method'], $request['url']);

        //Headers
        $this->parseHeader($request['header']);

        //Body
        $this->parseBody($request['body']);
    }

    protected function parseUrl(string $method, array $url): void
    {
        $method = "{$method} ";
        $url    = $url['raw'];

        $this->writeH('URL', 5);
        $this->writeCode($method);
        $this->writeCode($url);
        $this->writeEnter();
    }

    protected function parseHeader(array $header): void
    {
        if (count($header)) {
            $this->writeH('HEADER', 5);
            $this->writeTable($this->headerTitle, $header);
        }
    }

    protected function parseBody(array $body): void
    {
        if (empty($body))
            return;

        switch ($body['mode']) {
            case 'raw':
                $raw     = $body['raw'];
                $rawData = json_decode($raw, true);
                $data    = [];

                if (json_last_error() === 0) {
                    foreach ($rawData as $key => $value) {
                        $type = gettype($value);
                        $type === 'array' && $value = json_encode($value);

                        $data[] = [
                            'key'   => $key,
                            'type'  => $type,
                            'value' => $value,
                        ];
                    }
                }
                break;
            case 'formdata':
                $data = $body['formdata'];
                break;
            case 'urlencoded':
                $data = $body['urlencoded'];
                break;
            default:
                $data = [];
                break;
        }

        if (count($data)) {
            $this->writeH('BODY', 5);
            $this->writeTable($this->bodyTitle, $data);
            if (isset($raw)) {
                $this->writeH('RAW BODY', 5);
                $this->writeCode($raw, true);
            }
        }
    }
}
