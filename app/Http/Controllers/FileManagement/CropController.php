<?php namespace App\Http\Controllers\FileManagement;

use Intervention\Image\Facades\Image;
use Unisharp\Laravelfilemanager\Events\ImageIsCropping;
use Unisharp\Laravelfilemanager\Events\ImageWasCropped;

/**
 * Class CropController
 */
class CropController extends LfmController
{
    /**
     * Show crop page
     *
     * @return mixed
     */
    public function getCrop()
    {
        $working_dir = request('working_dir');
        $img = parent::objectPresenter(parent::getCurrentPath(request('img')));

        return view('registry.crop')
            ->with(compact('working_dir', 'img'));
    }


    /**
     * Crop the image (called via ajax)
     */
    public function getCropimage()
    {
        $dataX      = request('dataX');
        $dataY      = request('dataY');
        $dataHeight = request('dataHeight');
        $dataWidth  = request('dataWidth');
        $image_path = parent::getCurrentPath(request('img'));

        event(new ImageIsCropping($image_path));
        // crop image
        Image::make($image_path)
            ->crop($dataWidth, $dataHeight, $dataX, $dataY)
            ->save($image_path);

        // make new thumbnail
        Image::make($image_path)
            ->fit(config('lfm.thumb_img_width', 200), config('lfm.thumb_img_height', 200))
            ->save(parent::getThumbPath(parent::getName($image_path)));
        event(new ImageWasCropped($image_path));
        Audit::log(Auth::user()->id, trans('registry/lfm.audit-log.category'), trans('registry/lfm.audit-log.msg-index'));
    }
}
