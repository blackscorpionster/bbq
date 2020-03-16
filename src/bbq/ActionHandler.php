<?php

declare(strict_types=1);

namespace src\bbq;
use src\config\App;
use src\config\Routes;
use src\bbq\UploadedFile;
use src\bbq\Route;

class ActionHandler {
	public const VALID_HTTP_METHODS = [
		"POST",
		"GET",
		"PUT",
		"PATCH",
		"DELETE",
	];

	public const CLASS_NAME_AS_PARAMETER = "actionHandler";

	private string $app = App::APP_NAME;
	private string $method = "POST";
	private array $routes = [];
	private string $url = "";
	private array $query = [];
	private array $headers = [];
	private string $contentType = "";
	private array $request = [];
	private array $jsonData = [];
	private array $files = []; 
	private ?Route $route = null;

	public function __construct(Routes $routes) {
		$this->routes = $routes->getRoutes();
		$this->processUrl();
		$this->processHeaders();
		$this->processContentType();
		$this->processFiles();
		$this->matchUrl();
	}

	/**
	 * @return Route|null
	 */
	public function getRoute(): ?Route 
	{
		return $this->route;
	}

	private function processUrl(): void
	{
		if (empty($_SERVER['REQUEST_URI'])) {
			throw new \Exception("Wrong url");
		}
		$urlDecoded = \urldecode($_SERVER['REQUEST_URI']);
		$parsedUrl = parse_url($urlDecoded);
		if (empty($parsedUrl["path"])) {
			throw new \Exception("Wrong url");
		}
		$this->url = $parsedUrl["path"];
		if (!empty($parsedUrl["query"])) {
			 parse_str($parsedUrl["query"], $this->query);
		}
	}

	private function processHeaders(): void
	{
		if (empty($_SERVER["REQUEST_METHOD"])) {
			throw new \Exception("Wrong request method");
		}
		$method = $_SERVER["REQUEST_METHOD"];
		if (!\in_array($method, self::VALID_HTTP_METHODS)) {
			throw new \Exception("Wrong request method");
		}
		$this->method = $method;
		
		$headers = \getallheaders();
		$this->headers = $headers;
	}

	/**
	 * Each request has one content type only
	 */
	private function processContentType(): void
	{		
		if (!empty($_SERVER["CONTENT_TYPE"])) {
			$contentType = $_SERVER["CONTENT_TYPE"];
			$this->contentType = $contentType;
			
			$this->processFormBody();

			if ('application/json' === $this->contentType) {
				$this->processJsonBody();
			}
		}
	}

	private function processFormBody(): void
	{
		if ("POST" === $this->method) {
			$formData = $_POST;
		}

		$formData = $_REQUEST;

		$formData = array_merge($formData, $_REQUEST);
		
		$this->request = $formData;
	}

	private function processJsonBody(): void
	{
		$jsonData = file_get_contents('php://input');

		$decodedRequest = \json_decode($jsonData, true);
		if (JSON_ERROR_NONE !== \json_last_error()) {
			throw new \Exception("Malformed json request");
		}

		if (!empty($decodedRequest) && \is_array($decodedRequest)) {
			$this->jsonData = $decodedRequest;
		}
	}

	private function processFiles(): void {
		foreach($_FILES as $fileData) {
			$this->files[] = new UploadedFile($fileData);
		}
	}
	
	private function matchUrl(): void
	{
		$urlParts = explode('/', $this->url);
		$urlPartsQty = \count($urlParts);

		foreach ($this->routes as $idx => $route) {
			$parts = $route->getRouteParts();

			// Http method from the req must match that on the routes
			if (strtolower($route->getRequestMethod()) !== strtolower($this->method)) {
				continue;
			}

			// print"<pre>";
			// print_r($parts);
			// print_r($urlParts);
			if (\count($parts) !== $urlPartsQty) {
				continue;
			}

			$match = $this->matchUrlParts($parts, $urlParts);

			// print_r($match);exit();

			if (empty($match)) {
				continue;
			}

			$route->setRouteParts($match);
			$this->route = $route;
		}
	}

	private function matchUrlParts(array $routeParts, array $urlParts): array {
		$routePieces = [];
		foreach($urlParts as $idx => $piece) {
			$routePart = $routeParts[$idx];
			if (\strpos($routePart, ":") === false) {
				if ($routePart !== $piece) {
					return [];
				}
			}
			$routePieces[$routePart] = $piece;
		}
		
		return $routePieces;
	}

	/**
	 * Get the value of request
	 */ 
	public function getRequest(): array
	{
		return $this->request;
	}

	/**
	 * Get the value of jsonData
	 */ 
	public function getJsonData(): array
	{
		return $this->jsonData;
	}

	/**
	 * Get the value of query
	 */ 
	public function getQuery(): array
	{
		return $this->query;
	}

	/**
	 * Get the value of files
	 */ 
	public function getFiles(): array
	{
		return $this->files;
	}
}
