<?php

declare(strict_types=1);

final class Router
{
    private string $documentRoot;
    private string $requestPath;

    public function __construct(string $documentRoot)
    {
        $this->documentRoot = rtrim($documentRoot, '/');

        $requestPath = parse_url(
            $_SERVER['REQUEST_URI'] ?? '/',
            PHP_URL_PATH
        );

        if (!is_string($requestPath) || $requestPath === '') {
            $requestPath = '/';
        }

        // Decode URL path once.
        $requestPath = rawurldecode($requestPath);

        // Normalize leading slash.
        $requestPath = '/' . ltrim($requestPath, '/');

        // Collapse repeated slashes.
        $requestPath = preg_replace('#/+#', '/', $requestPath);

        $this->requestPath = is_string($requestPath)
            ? $requestPath
            : '/';
    }

    public function handle(): void
    {
  
        // BASIC PATH VALIDATION
        // Reject null bytes.
        if (str_contains($this->requestPath, "\0")) {
            $this->forbidden();
        }

        // Remove leading slash for route processing.
        $route = ltrim($this->requestPath, '/');

         /* Reject path traversal.
         
         * This also catches encoded traversal because the URL was
         * decoded above before this check.
         */
      
        if (str_contains($route, '..') || str_contains($route, '\\')){
         
            $this->forbidden();
        }

       
    /* ONLY CLEAN ROUTES ARE ALLOWED
            
         * Reject any route segment that looks like a filename:
         *
         *   /test.php
         *   /test.sphp
         *   /test.shell
         *   /test.exe
         *   /test.js
         *   /test.jpg
         *   /api/user.php
         *   /api/login.php
         *   /blog/post.html
         *
         * Static files will not reach Router because Apache serves existing files directly.
         
         * This is an additional safety layer in case a request somehow reaches Router anyway.
         */

     if ($route !== '' && preg_match(
    '/(?:^|\/)[^\/]+\.(?:php[0-9]*|phtml|phar|phps)(?:\/|$)/i', 
            $route
        )) {
    $this->forbidden();
    }

     
        /* HOME ROUTE
         * "/" maps to /index.html
         */

        if ($route === '') {
            $this->serveHtml('index.html');
        }

       /*
       HTML ROUTE
        
         * Example:
         *
         *   /about
         *   /blog/post
         *   /api/settings
         *
         * First check for html file, it exists then serve it
         
         *The route will map to :
         *   /about.html
         *   /blog/post.html
         *   /api/settings.html
         */

        $htmlFile = $this->documentRoot.'/' .$route.'.html';

        if (is_file($htmlFile)) {
            $this->serveHtml($htmlFile);
        }

      
        /* PHP ROUTE
        If the html file 
        matching the route does not exist, try its php file
      
         *   /about.php
         *   /blog/post.php
         *   /api/settings.php
         *
         * The PHP file is executed internally and the browser never sees the .php filename.
         */

       $phpFile = $this->documentRoot.'/'.$route.'.php';

        if (is_file($phpFile)) {
            require $phpFile;
            exit;
        }

        /*
         * NOTHING MATCHED
      If there is no matching html or php file for the request, return 404 - not found
         */

        $this->notFound();
    }

 
 
    private function serveHtml(string $file): never
    {
        $fullPath = str_starts_with($file, $this->documentRoot)
            ? $file
            : $this->documentRoot.'/'.ltrim($file, '/');

        if (!is_file($fullPath)) {
            $this->notFound();
        }

        header('Content-Type: text/html; charset=UTF-8');

        readfile($fullPath);
        exit;
    }

 
 
    private function forbidden(): never
    {
        http_response_code(403);

        $errorPage = $this->documentRoot.'/403.shtml';

        if (is_file($errorPage)) {
            require $errorPage;
        } else {
            echo '403 - Forbidden';
        }

        exit;
    }

  
    private function notFound(): never
    {
        http_response_code(404);

        $errorPage = $this->documentRoot.'/404.shtml';

        if (is_file($errorPage)) {
            require $errorPage;
        } else {
            echo '404 - Page Not Found';
        }

        exit;
    }
}