<?php

class Router {
    private string $baseDir;

    public function __construct(string $directory) {
        // Correct constructor
        $this->baseDir = rtrim($directory, "/");
    }

    public function handle_route(string $URL): void {
    
        // Extract only the path, ignore query strings
       $path = $this->normalize_route(parse_url($URL, PHP_URL_PATH));


        //Home page support
        if ($path === '/' || $path === '/index.php' || $path === '/index') {
            $home = $this->baseDir . "/home.php";
            if (file_exists($home)) {
            
                require $home;
                return;
            }
        }

        // Build file path
        $file = $this->baseDir . $path . ".php";
     
  
   
        // directory index support: admin/exams → admin/exams/index.php
      if (is_dir($this->baseDir . $path)) {
            $file = $this->baseDir . $path . "/index.php";
        }

        // Load real file if it exists
        if (file_exists($file)) {
          
            require $file;
            return;
        }

        // 404 error
       http_response_code(404);
    // echo "<h3>404 - Page Not Found</h3>";
     $notfound = $this->baseDir . "/404.shtml";
        require $notfound;
    }

    private function normalize_route(string $path): string {
        // Clean up paths
        $path = preg_replace('#^\./#', '', $path);
        $path = preg_replace('#^\../#', '', $path);
        $path = preg_replace('#/+#', '/', $path);


// If no leading slash → treat as relative to current URL
if (!str_starts_with($path, '/')) {
    $current = dirname(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    if ($current === '/') {
        $path = '/' . $path;
    } else {
      $path = rtrim($current, '/') . '/' . $path;
    }
}

      // Remove trailing slash except root
        $path = rtrim($path, '/');
        return $path === '' ? '/' : $path;
    }
}