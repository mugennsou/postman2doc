# Convert postman collection.json to document

## Introduction

It is a convert postman collection.json to simple markdown/html/docx document tool. 

## Installation

You can install it with following command. recommended to install to the global, and you need to add global composer `vendor/bin` to the PATH.

```bash
composer global require mugen/postman2doc
```

## Usage

The following command can convert a file named 'postman_collection.json'. 

```bash
postman2doc convert /path/to/postman_collection.json
```

OR you can run `postman2doc` directly, then you will see the command I/O.  

If you want convert to html & docx document, use following command.

```bash
postman2doc convert /path/to/postman_collection.json --html --docx --no-md
```
OR
```bash
postman2doc convert:html /path/to/postman_collection.json

postman2doc convert:docx /path/to/postman_collection.json
```

If convert success, you will receive a system notification, then you can see the document file at same folder.

## Features

Convert postman collection.json to...

✓ markdown
✓ HTML
✓ docx
✘ PDF

## License

Released under the MIT license

## Thanks

This tool is base on [laravel-zero](https://github.com/laravel-zero/laravel-zero)
