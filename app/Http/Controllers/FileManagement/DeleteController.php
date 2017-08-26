<?php namespace App\Http\Controllers\FileManagement;

use Illuminate\Support\Facades\File;
use Unisharp\Laravelfilemanager\Events\ImageIsDeleting;
use Unisharp\Laravelfilemanager\Events\ImageWasDeleted;
use DB;
use Auth;
use App\Models\AppModels\Activity;

/**
 * Class CropController
 */
class DeleteController extends LfmController
{
    /**
     * Delete image and associated thumbnail
     *
     * @return mixed
     */
    public function getDelete()
    {
        $name_to_delete = request('items');

        $file_to_delete = parent::getCurrentPath($name_to_delete);
        $thumb_to_delete = parent::getThumbPath($name_to_delete);

        event(new ImageIsDeleting($file_to_delete));

        if (is_null($name_to_delete)) {
            return parent::error('folder-name');
        }

        if (!File::exists($file_to_delete)) {
            return parent::error('folder-not-found', ['folder' => $file_to_delete]);
        }

        if (File::isDirectory($file_to_delete)) {
            if (!parent::directoryIsEmpty($file_to_delete)) {
                return parent::error('delete-folder');
            }

            File::deleteDirectory($file_to_delete);

            return parent::$success_response;
        }

        if (parent::fileIsImage($file_to_delete)) {
            File::delete($thumb_to_delete);
        }

        File::delete($file_to_delete);

        event(new ImageWasDeleted($file_to_delete));
        Audit::log(Auth::user()->id, trans('registry/lfm.audit-log.category'), trans('registry/lfm.audit-log.msg-destroy'));

        // delete file from the database...
        
        // $new_name = parent::translateFromUtf8(trim(request('items'))); 
        $folder_name = request('items');
        $folder = DB::table('folders')->where('folder_no', $folder_name)->first();

        $activity = new Activity;
        $activity->activity_by= Auth::user()->email;
        $activity->activity_by_post = Auth::user()->position;        
        $activity->folder_id = $folder->id;               
        $activity->fileinfo  = $folder_name;
        $activity->activity  = 'One folder deleted from system';
        $activity->save();

        DB::table('folders')->where('folder_no', $folder_name)->delete();
        Activity::where('element_id', $folder->id)->delete(); // delete all activities associated to the folder
        

        return parent::$success_response;
    }
}
