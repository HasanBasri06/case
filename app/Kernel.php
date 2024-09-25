<?php

namespace App;

class Kernel
{
    private $consoleName = 'basri';
    public function run() {
        include __DIR__ . '/web.php';
    }

    public function startTextMode($class, $method, $matches) {
        echo (new $class)->$method(...$matches);
    }

    public function startArrayMode($class, $method, $matches) {
        $array = (new $class)->$method(...$matches);
        
        if (isset($array['type']) && $array['type'] == 'view') {
            if (!is_null($array['data'])) {
                extract($array['data']);
            }

            include __DIR__ . '/../'. $array['template'];
        }

        echo json_encode($array);
    }

    public function console($args) {
        if ($args[1] == 'serve') {
            shell_exec('php -S localhost:8000 index.php');
            die;
        }

        $this->isConsoleName($args[0]);
        $this->runMakeCommand($args[1], $args[2]);
    }

    public function isConsoleName(string $name) {
        try {
            if ($name != $this->consoleName) {
                throw new \Exception("Konsol ismi basri olmalıdır");
            }
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
            die;
        }
    }

    public function runMakeCommand($arguments, $value) {        
        $isIncludeParse = str_contains($arguments, ':');

        if (!$isIncludeParse) {
            throw new \Exception("Lütfen bir make örneği girin make:controller");
        }

        $explodeReq = explode(':', $arguments);

        if ($explodeReq[0] == 'make') {
            switch ($explodeReq[1]) {
                case 'controller':
                    $this->createController($value);
                    break;
                case 'model':
                    $this->createModel($value);
                    break;
                case 'view':
                    $this->createView($value);
                    break;
            }
        }
    }

    public function createController($fileName) {
        $filePath = __DIR__ . '/controller/'.$fileName.'.php';
        $fileExist = file_exists($filePath);

        if ($fileExist) {
            unlink($filePath);
        }

        touch(__DIR__ . '/controller/'.$fileName.'.php');
        $f = fopen($filePath, 'w+');
        $stream = "<?php\n\nnamespace App\Controller;\n\nclass $fileName {\n\n}";
        fwrite($f, $stream);
        fclose($f);
    }

    public function createModel($fileName) {
        $filePath = __DIR__ . '/model/'.$fileName.'.php';
        $fileExist = file_exists($filePath);

        if ($fileExist) {
            unlink($filePath);
        }

        touch(__DIR__ . '/model/'.$fileName.'.php');
        $f = fopen($filePath, 'w+');
        $stream = "<?php\n\nnamespace App\Model;\n\nclass $fileName extends Model {\n\n}";
        fwrite($f, $stream);
        fclose($f);
    }

    public function createView($fileName) {
        $filePath = __DIR__ . '/view/'.$fileName.'.php';
        $fileExist = file_exists($filePath);

        if ($fileExist) {
            unlink($filePath);
        }

        touch(__DIR__ . '/view/'.$fileName.'.php');
        $f = fopen($filePath, 'w+');
        $stream = "<!DOCTYPE html>\n<html lang='tr'>\n<head>\n  <meta charset='UTF-8'>\n  <meta name='viewport' content='width=device-width, initial-scale=1.0'>\n  <title>".$fileName."</title>\n</head>\n<body>\n  <h1>".$fileName." sayfasına hoşgeldiniz</h1>\n</body>\n</html>";
        fwrite($f, $stream);
        fclose($f);
    }
}