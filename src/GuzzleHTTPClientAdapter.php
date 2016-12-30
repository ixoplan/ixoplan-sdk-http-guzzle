<?php

namespace Ixolit\Dislo\HTTP\Guzzle;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use Ixolit\Dislo\HTTP\HTTPClientAdapter;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

class GuzzleHTTPClientAdapter implements HTTPClientAdapter {
	/**
	 * @return RequestInterface
	 */
	public function createRequest() {
		return new Request('GET', '/');
	}

	/**
	 * @return UriInterface
	 */
	public function createUri() {
		return new Uri();
	}

	/**
	 * @param string $string
	 *
	 * @return StreamInterface
	 */
	public function createStringStream($string) {
		return \GuzzleHttp\Psr7\stream_for($string);
	}

	/**
	 * @param RequestInterface $request
	 *
	 * @return ResponseInterface
	 */
	public function send(RequestInterface $request) {
		$client = new Client();
		try {
			return $client->send($request);
		} catch (ServerException $e) {
			return $e->getResponse();
		} catch (ClientException $e) {
			return $e->getResponse();
		}
	}
}
