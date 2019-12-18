<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;
use Storage;

use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\AbstractHandler;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

use Illuminate\Http\UploadedFile;

class upload extends Controller
{
    //
    public function index(Request $request){

        //phpinfo();
        //die;

        if ($request->hasFile('photo')) {
            $image      = $request->file('photo');
            $fileName   = 'test' . '.' . $image->getClientOriginalExtension();

            $img = Image::make($image->getRealPath());
            

            $img->stream('jpg', 10);
            
            Storage::disk('public')->put('images/'.$fileName, $img, 'public');
            $url = Storage::disk('public')->url('images/'.$fileName);
            dd($url);
        }

        return view('upload.index');
    }

    /**
     * Handles the file upload
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws UploadMissingFileException
     * @throws \Pion\Laravel\ChunkUpload\Exceptions\UploadFailedException
     */

    public function resumable(Request $request){
        // create the file receiver
        $receiver = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));

        // check if the upload is success, throw exception or return response you need
        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }

        // receive the file
        $save = $receiver->receive();

        // check if the upload has finished (in chunk mode it will send smaller files)
        if ($save->isFinished()) {
            // save the file and return any response you need, current example uses `move` function. If you are
            // not using move, you need to manually delete the file by unlink($save->getFile()->getPathname())
            return $this->saveFile($save->getFile());
        }

        // we are in chunk mode, lets send the current progress
        /** @var AbstractHandler $handler */
        $handler = $save->handler();

        return response()->json([
            "done" => $handler->getPercentageDone(),
        ]);
    }

    /**
     * Saves the file
     *
     * @param UploadedFile $file
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function saveFile(UploadedFile $file)
    {
        $size = $file->getSize();
        $fileName = $this->createFilename($file);
        // Group files by mime type
        $mime = str_replace('/', '-', $file->getMimeType());

        // Build the file path
        $filePath = "images/{$mime}/tmp/{$fileName}";
        $realPrivatePath = $file->getRealPath();
        $img = Image::make($realPrivatePath);
        $img->stream('jpg', 60);

        if(Storage::disk('public')->put($filePath, $img)){
            unset($img);
            if( unlink($realPrivatePath) ){
                die;
                return response()->json([
                    'path' => $filePath,
                    'name' => $fileName,
                    'mime_type' => $mime
                ]);
            }
        }
    }

    /**
     * Create unique filename for uploaded file
     * @param UploadedFile $file
     * @return string
     */
    protected function createFilename(UploadedFile $file)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = str_replace(".".$extension, "", $file->getClientOriginalName()); // Filename without extension

        // Add timestamp hash to name of the file
        $filename .= "_" . md5(time()) . "." . $extension;

        return $filename;
    }


    protected function convert($size)
    {
        //echo $this->convert(memory_get_usage(true)) . "\n";
        $unit=array('b','kb','mb','gb','tb','pb');
        return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
    }
}
