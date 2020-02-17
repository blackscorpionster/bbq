<?php

declare(strict_types=1);

namespace src\bbq;
use src\config\App;
use src\config\Routes;

class ActionHandler {
	public const VALID_HTTP_METHODS = [
		"POST",
		"GET",
		"PUT",
		"PATCH",
		"DELETE",
	];

	private string $app = App::APP_NAME;
	private string $method = "POST";
	private array $routes;
	private string $url = "";
	private string $query = "";
	private array $headers = [];
	private string $contentType = "";

	public function __construct() {
		$routes = new Routes();
		$this->routes = $routes->getRoutes();
		$this->processUrl();
		$this->processHeaders();
		$this->processContentType();
	}

	public function getRoutes(): array 
	{
		return $this->routes;
	}

	private function processUrl(): void
	{
		$urlDecoded = \urldecode($_SERVER['REQUEST_URI']);
		$parsedUrl = parse_url($urlDecoded);
		if (empty($parsedUrl["path"])) {
			throw new \Exception("Wrong url");
		}
		$this->url = $parsedUrl["path"];
		if (!empty($parsedUrl["query"])) {
			$this->query = $parsedUrl["query"];
		}
	}

	private function processHeaders(): void
	{
		$method = $_SERVER["REQUEST_METHOD"];
		if (empty($method) || !\in_array($method, self::VALID_HTTP_METHODS)) {
			throw new \Exception("Wrong request method");
		}
		$this->method = $method;
		$contentType = $_SERVER["CONTENT_TYPE"];
		$headers = \getallheaders();
		$this->headers = $headers;
		if ($contentType !== $headers["Content-Type"]) {
			throw new \Exception("Wrong content type");
		}
		$this->contentType = $contentType;
	}

	private function processContentType(): void
	{
		// Files
		if (false !== strpos($this->contentType, 'multipart/form-data')) {
			$this->processFormBody();
		}

		// Json data
		if (false !== strpos($this->contentType, 'application/json')) {
			$this->processJsonBody();
		}
		print($this->contentType);
	}

	private function processFormBody(): void
	{
		// json reuqest
		if ("POST" === $this->method) {
			$formData = $_POST;
		} else {
			$formData = $_REQUEST;
		}
		
		print_r($formData);
	}

	private function processJsonBody(): void
	{
		// json reuqest
		$jsonData = file_get_contents('php://input');
		$decodedRequest = \json_decode($jsonData, true);
		if (JSON_ERROR_NONE !== \json_last_error()) {
			throw new \Exception("Malformed json request");
		}
		print_r($decodedRequest);
	}
}
