# Convert postman collection.json to a markdown document

## Introduction

It ia a convert postman collection.json to simple markdown document tool. 

## Installation

You can install it with following command. recommended to install to the global, and you need to add global composer `vendor/bin` to the PATH.

```bash
composer global require mugen/postman2doc
```

## Usage

The following command can convert a file named 'postman_collection.json'. 

```bash
postman2doc convert postman_collection.json
```

OR you can run `postman2doc` directly, then you will see command I/O.  

If convert success, you will receive a system notification, and you can see the markdown file at same folder.

## Features

Convert postman collection.json to...

✓ markdown
✘ multi markdown file
✓ HTML
✘ PDF
✘ docx

## License

Released under the MIT license

## Thanks

This tool is base on [laravel-zero](https://github.com/laravel-zero/laravel-zero)
