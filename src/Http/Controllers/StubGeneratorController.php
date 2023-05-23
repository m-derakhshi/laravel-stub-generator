<?php

namespace MDerakhshi\LaravelStubGenerator\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use MDerakhshi\LaravelStubGenerator\Classes\StubGeneratorClass;

class StubGeneratorController extends Controller
{

    public function index(Request $request, ?string $sourceType = null)
    {
        if ( ! is_null($sourceType)) {
            $sourceType = Str::studly($sourceType);
        }
        $stubGeneratorObject = new StubGeneratorClass();
        $treeFilesCheckbox   = null;
        $sourceDirectory     = base_path('stubs');
        $configStubGenerator = config('stubGenerator.directories', []);
        $directoriesName     = $stubGeneratorObject->getDirectories($sourceDirectory, $configStubGenerator);
        $targetDirectories   = [];
        $targetPath          = null;
        $destinationParents  = null;
        if ( ! empty($sourceType) && array_key_exists($sourceType, $configStubGenerator)) {
            $sourceDirectory    .= '/'.$sourceType;
            $targetDirectories  = $configStubGenerator[$sourceType]['targets'];
            $targetSelected     = $configStubGenerator[$sourceType]['targets'][$_POST['targetDirectory'] ?? 0];
            $targetPath         = $targetSelected['path'];
            $targetPath         = str_ends_with($targetPath, '/') ? $targetPath : $targetPath.'/';

            if (request()->method() == 'POST' && is_array($request->input('dependency')) && count($request->input('dependency')) > 0) {
                $directoryName = ( ! is_null($request->input('parent', null))) ? $request->input('parent') : $request->input('name');
                $stubGeneratorObject->handle([
                  'namespace'       => $targetSelected['namespace'],
                  'sourceDirectory' => $sourceDirectory,
                  'targetDirectory' => $targetPath.ucfirst($directoryName),
                  'name'            => $request->input('name'),
                  'parent'          => ( ! is_null($request->input('parent', null))) ? $request->input('parent') : $request->input('name'),
                  'files'           => $request->input('dependency'),
                ]);
            }

            $destinationParents = $stubGeneratorObject->getDirectories($targetPath, []);
            if (isset($_POST['getFiles']) && $_POST['getFiles'] == 'true') {
                $options = '<option value="">-</option>';
                foreach ($destinationParents as $optionName) {
                    $options .= '<option value="'.$optionName.'">'.$optionName.'</option>';
                }
                echo "$('#targetParent').find('option').remove().end().append('".$options."')";
                exit;
            }
            $filesArray = $stubGeneratorObject->getTreeFilesArray($sourceDirectory);
            $stubGeneratorObject->array_sort_by_column($filesArray, 'is_file');
            $treeFilesCheckbox = $stubGeneratorObject->getTreeFilesCheckbox($filesArray);
        }

        return view()->file(__DIR__.'/../../resources/views/index.blade.php', compact('targetDirectories', 'treeFilesCheckbox', 'directoriesName', 'destinationParents', 'sourceType', 'targetPath',));
    }

}