# Nocriz API

[![Build Status](https://travis-ci.org/nocriz/restler.png)](https://travis-ci.org/nocriz/restler)

Nocriz API is a PHP micro framework that helps you.

## Features

* Powerful router
    * Standard and custom HTTP methods
    * Route parameters with wildcards and conditions
    * Route redirect, halt, and pass
    * Route middleware
* Template rendering with custom views
* Flash messages
* Secure cookies with AES-256 encryption
* HTTP caching
* Logging with custom log writers
* Error handling and debugging
* Middleware and hook architecture
* Simple configuration

## Getting Started

### Install

You may install the Nocriz Framework with Composer (recommended) or manually.

[Read how to install Nocriz](http://docs.nocriz.com/getting-started-install)

### System Requirements

You need **PHP >= 5.3.0**. If you use encrypted cookies, you'll also need the `mcrypt` extension.

You need **Restler**.

### Tutorial

system = Name system

token = private key

client = class Api\Client;

GET [system/public/client] Retrieve all

GET [system/public/client/1] Retrieve with id == 1

POST [system/public/client] Add a new

PUT [system/public/client/1] Update with id == 1

DELETE [system/client/1] Delete with id == 1
