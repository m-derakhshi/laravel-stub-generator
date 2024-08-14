<?php

namespace MDerakhshi\LaravelStubGenerator\Classes;

use Illuminate\Support\Str;
use MDerakhshi\LaravelAttachment\Helpers;

class StubGeneratorClass
{

    protected int $treeFilesCheckboxCounter = 0;

    protected array $data
      = [
        'sourceDirectory' => null,
        'targetDirectory' => null,
        'name'            => null,
        'parent'          => null,
        'files'           => [],
        'ignoreFiles'     => ['.gitkeep'],
      ];

    public function handle(array $data): void
    {
        $this->data = array_merge($this->data, $data);
        if ( ! is_null($this->data['sourceDirectory']) && ! is_null($this->data['targetDirectory']) && ! is_null($this->data['name'])) {
            $this->copyModuleStubs($this->data['sourceDirectory'], $this->data['targetDirectory'], $this->data['files']);
        }
    }

    protected function replaceConfigModule($content): string
    {
        $stubBase             = basename($this->data['sourceDirectory']);
        $this->data['parent'] = $this->data['parent'] ?? $this->data['name'];
        $replaces             = [
          '@Stubs\\\\'.$stubBase.'@' => $this->data['namespace'].'\\'.ucfirst($this->data['parent']),
          '@TestTest@'               => ucfirst($this->data['name']),
          '@testTest@'               => lcfirst($this->data['name']),
          '@test-test@'              => Str::kebab($this->data['name']),
          '@test_test@'              => Str::snake($this->data['name']),

          '@TestParent@' => ucfirst($this->data['parent']),
          '@testParent@'   => lcfirst($this->data['parent']),
          '@test-parent@'  => Str::kebab($this->data['parent']),
          '@test_parent@'  => Str::snake($this->data['parent']),

          '@%NAMESPACE%@'   => $this->data['namespace'],
          '@%STUDLY_NAME%@' => ucfirst($this->data['name']),
          '@%LOWER_NAME%@'  => lcfirst($this->data['name']),
          '@%KEBAB_NAME%@'  => Str::kebab($this->data['name']),
          '@%SNAKE_NAME%@'  => Str::snake($this->data['name']),

          '@%STUDLY_PARENT%@' => ucfirst($this->data['parent']),
          '@%LOWER_PARENT%@'  => lcfirst($this->data['parent']),
          '@%KEBAB_PARENT%@'  => Str::kebab($this->data['parent']),
          '@%SNAKE_PARENT%@'  => Str::snake($this->data['parent']),

          '@%YEAR%@'      => date('Y'),
          '@%MONTH%@'     => date('m'),
          '@%DAY%@'       => date('d'),
          '@%TIMESTAMP%@' => ((((int) date('H') * 60) + (int) date('i')) * 60) + (int) date('s'),
        ];

        return preg_replace(array_keys($replaces), array_values($replaces), $content);
    }

    public function getDirectories(string $sourceDirectory, array $configStubGenerator = []): array
    {
        $response  = [];
        $directory = opendir($sourceDirectory);
        while (($file = readdir($directory)) !== false) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            if (is_dir($sourceDirectory.'/'.$file)) {
                $response[] = $file;
            }
        }
        closedir($directory);
        if (count($configStubGenerator) > 0) {
            foreach ($response as $key => $file) {
                if ( ! array_key_exists($file, $configStubGenerator)) {
                    unset($response[$key]);
                }
            }
        }
        sort($response);

        return $response;
    }

    public function getTreeFilesArray(string $sourceDirectory, string $prefixDirectory = ''): array
    {
        $responseArray = [];
        $directory     = opendir($sourceDirectory);
        while (($file = readdir($directory)) !== false) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            $filePath = $sourceDirectory.'/'.$file;
            if (is_dir($filePath)) {
                $responseArray[] = ['is_file' => false, 'name' => $file, 'prefixDirectory' => $prefixDirectory, 'subset' => $this->getTreeFilesArray($filePath, $prefixDirectory.$file.'/')];
            }
        }
        closedir($directory);
        $directory = opendir($sourceDirectory);
        while (($file = readdir($directory)) !== false) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            $filePath = $sourceDirectory.'/'.$file;
            if (is_file($filePath) && ! in_array($file, $this->data['ignoreFiles'])) {
                $responseArray[] = ['is_file' => true, 'name' => $file, 'prefixDirectory' => $prefixDirectory];
            }
        }
        closedir($directory);

        return $responseArray;
    }

    public static function array_sort_by_column(array &$arr, string $col, int $dir = SORT_ASC): void
    {
        $sort_col = [];
        foreach ($arr as $key => $row) {
            $sort_col[$key] = $row[$col] ?? 1000;
        }
        array_multisort($sort_col, $dir, $arr);
    }

    public function getTreeFilesCheckbox(array $allFilesArray): string
    {
        $responseHTML = '';
        foreach ($allFilesArray as $fileInfo) {
            $this->treeFilesCheckboxCounter++;
            $checkedStatus = ( ! request()->has('dependency') || in_array($fileInfo['prefixDirectory'].$fileInfo['name'], request('dependency'))) ? 'checked' : '';
            if (array_key_exists('subset', $fileInfo)) {
                $directoryId  = 'stubFilesDirectory'.$this->treeFilesCheckboxCounter;
                $responseHTML .= '<label data-real-name="'.$fileInfo['name'].'" for="checkbox-'.$this->treeFilesCheckboxCounter.'"> <input '.$checkedStatus
                  .' type="checkbox" name="dependency[]" value="'.$fileInfo['prefixDirectory'].$fileInfo['name'].'" onclick="setAllCheckboxes(\''.$directoryId.'\',this)" id="checkbox-'
                  .$this->treeFilesCheckboxCounter.'" /><span>'.$fileInfo['name'].'</span></label>';
                $responseHTML .= '<div  id="'.$directoryId.'" style="padding-left: 20px">';
                $responseHTML .= $this->getTreeFilesCheckbox($fileInfo['subset']);
                $responseHTML .= "</div>";
            } else {
                $responseHTML .= ' <label data-real-name="'.$fileInfo['name'].'" for="checkbox-'.$this->treeFilesCheckboxCounter.'"> <input '.$checkedStatus
                  .' type="checkbox" name="dependency[]" value="'.$fileInfo['prefixDirectory'].$fileInfo['name'].'"  id="checkbox-'.$this->treeFilesCheckboxCounter.'" /><span>'.$fileInfo['name']
                  ."</span></label><br>";
            }
        }

        return $responseHTML;
    }

    private function getFiles(string $sourceDirectory, string $prefixDirectory = ''): array
    {
        $filesArray = [];
        $directory  = opendir($sourceDirectory);
        while (($file = readdir($directory)) !== false) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            $filePath = $sourceDirectory.'/'.$file;
            if (is_dir($filePath)) {
                $directoryFiles = $this->getFiles($filePath, $prefixDirectory.$file.'/');
                if (count($directoryFiles) == 0) {
                    $filesArray[] = $prefixDirectory.$file;
                } else {
                    $filesArray = array_merge($filesArray, $directoryFiles);
                }
            } elseif ( ! in_array($file, $this->data['ignoreFiles'])) {
                $filesArray[] = $prefixDirectory.$file;
            }
        }
        closedir($directory);

        return $filesArray;
    }

    function copyModuleStubs(string $sourceDirectory, string $destinationDirectory, array $sourceFiles = []): void
    {
        if ( ! file_exists($destinationDirectory) || ! is_dir($destinationDirectory)) {
            Helpers::makeDirectoryPath($destinationDirectory);
        }
        $sourceFiles = count($sourceFiles) == 0 ? $this->getFiles($sourceDirectory) : $sourceFiles;
        foreach ($sourceFiles as $file) {
            $newFileName = $this->replaceConfigModule($file);

            if (is_dir($sourceDirectory.'/'.$file)) {
                if ( ! file_exists($destinationDirectory.'/'.$newFileName) || ! is_dir($destinationDirectory.'/'.$newFileName)) {
                    Helpers::makeDirectoryPath($destinationDirectory.'/'.$newFileName);
                }
                continue;
            }
            $fileType = '.'.strtolower(pathinfo($file, PATHINFO_EXTENSION));
            $dirName  = dirname($destinationDirectory.'/'.$newFileName);
            if ( ! file_exists($dirName) || ! is_dir($dirName)) {
                Helpers::makeDirectoryPath($dirName);
            }

            $newFilePath = $destinationDirectory.'/'.$newFileName;
            if (in_array($fileType, config('stubGenerator.fileTypeRemove'))) {
                $newFilePath = substr($newFilePath, 0, -1 * strlen($fileType));
            }

            if (in_array($fileType, config('stubGenerator.fileTypeRewrite'))) {
                if ( ! file_exists($newFilePath)) {
                    $newFileContent = $this->replaceConfigModule(file_get_contents($sourceDirectory.'/'.$file));
                    file_put_contents($newFilePath, $newFileContent);
                }
            } elseif ( ! file_exists($newFilePath)) {
                copy($sourceDirectory.'/'.$file, $newFilePath);
            }
        }
    }

}
