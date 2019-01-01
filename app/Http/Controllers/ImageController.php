<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Filesystem\Filesystem;
use League\Glide\Responses\LaravelResponseFactory;
use League\Glide\ServerFactory;

class ImageController extends Controller
{
    public function show(Filesystem $filesystem, $path)
    {
        $server = ServerFactory::create([
            'response' => new LaravelResponseFactory(app('request')),
            'source' => $filesystem->getDriver(),
            'cache' => $filesystem->getDriver(),
            'source_path_prefix' => 'public',
            'cache_path_prefix' => 'public/.cache',
//            'base_url' => 'img',
        ]);

        return $server->getImageResponse($path, request()->all());
    }
}
