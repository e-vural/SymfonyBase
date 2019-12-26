<?php
/**
 * Created by PhpStorm.
 * User: emrevural
 * Date: 2018-12-17
 * Time: 13:34
 */

namespace Project\Utils\Core\Php;


use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageUpload
{

    public function getUuid()
    {


        return md5(uniqid());
//        $uuid1 = Uuid::uuid1();
//        return $uuid1->toString(); // i.e. e4eaaaf2-d142-11e1-b3e4-080027620cdd

    }

    public function imageUpload(UploadedFile $file, $dir, $fileName = null, $allowedExt = array())
    {

        $fs = new Filesystem();

        if (!$fs->exists($dir)) {
            $fs->mkdir($dir);
        }

        $ext = $file->getClientOriginalExtension();
//        if (count($allowedExt) > 0) {
//            if (!in_array($ext, $allowedExt)) {
//                return false;
//            }
//        }

        $mimeType = $file->getClientMimeType();

        //$ext2 = $file->getClientOriginalExtension();
        // $ext3 = $file->guessClientExtension();

        if (!$fileName) {
            $fileName = $this->getUuid();

        }

//        $kontrol = $this->uzantiKontrol($mimeType);
//
//        if(!$kontrol){
//            return false;
//        }

        $fileName = $fileName . '.' . $ext;

        $isSuccess = $file->move(
            $dir,
            $fileName
        );

        if ($isSuccess) {
            return $fileName;
        }

        return false;


    }

    public function imageDelete($path)
    {

        $fs = new Filesystem();

        if ($fs->exists($path)) {

            $fs->remove($path);
        }


    }

    public function base64_to_jpeg($base64_string, $output_file)
    {


        // open the output file for writing
        $ifp = fopen($output_file, 'wb');

        // split the string on commas
        // $data[ 0 ] == "data:image/png;base64"
        // $data[ 1 ] == <actual base64 string>
        $data = explode(',', $base64_string);

        // we could add validation here with ensuring count( $data ) > 1
        fwrite($ifp, base64_decode($data[1]));

        // clean up the file resource
        fclose($ifp);

        return $output_file;
    }

}
