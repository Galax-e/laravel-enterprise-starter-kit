<?php namespace App\Http\Controllers\FileManagement;

use Illuminate\Support\Facades\File;
use Unisharp\Laravelfilemanager\Events\ImageIsRenaming;
use Unisharp\Laravelfilemanager\Events\ImageWasRenamed;
use Unisharp\Laravelfilemanager\Events\FolderIsRenaming;
use Unisharp\Laravelfilemanager\Events\FolderWasRenamed;

use Illuminate\Support\Facades\Input;
use App\Models\AppModels\Activity;
use App\Models\AppModels\Folder;
use Auth;
/**
 * Class RenameController
 */
class RenameController extends LfmController
{
    /**
     * @return string
     */
    public function getRename()
    {
        $old_name = parent::translateFromUtf8(request('file'));
        $new_name = parent::translateFromUtf8(trim(request('new_name')));

        $old_file = parent::getCurrentPath($old_name);

        if (empty($new_name)) {
            if (File::isDirectory($old_file)) {
                return parent::error('folder-name');
            } else {
                return parent::error('file-name');
            }
        }

        if (!File::isDirectory($old_file)) {
            $extension = File::extension($old_file);
            $new_name = str_replace('.' . $extension, '', $new_name) . '.' . $extension;
        }

        $new_file = parent::getCurrentPath($new_name);

        if (File::isDirectory($old_file)) {
            event(new FolderIsRenaming($old_file, $new_file));
        } else {
            event(new ImageIsRenaming($old_file, $new_file));
        }

        if (config('lfm.alphanumeric_directory') && preg_match('/[^\w-]/i', $new_name)) {
            return parent::error('folder-alnum');
        } elseif (File::exists($new_file)) {
            return parent::error('rename');
        }

        if (File::isDirectory($old_file)) {
            File::move($old_file, $new_file);
            event(new FolderWasRenamed($old_file, $new_file));
            Audit::log(Auth::user()->id, trans('registry/lfm.audit-log.category'), trans('registry/lfm.audit-log.msg-rename', ['fold_name' => $old_name]));
            return parent::$success_response;
        }

        if (parent::fileIsImage($old_file)) {
            File::move(parent::getThumbPath($old_name), parent::getThumbPath($new_name));
        }

        File::move($old_file, $new_file);

        event(new ImageWasRenamed($old_file, $new_file));
        Audit::log(Auth::user()->id, trans('registry/lfm.audit-log.category'), trans('registry/lfm.audit-log.msg-rename-img'));

        return parent::$success_response;
    }

    Public function getMove()
    {
        $new_name = parent::translateFromUtf8(trim(request('items')));        
        $old_file = parent::getCurrentPath($new_name);
        $new_path = public_path().'/docs/files/shares/kiv/'.$new_name;
        $move     =  File::copyDirectory($old_file, $new_path);
        $delete   =  File::deleteDirectory($old_file);


        $activity = new Activity;
        $activity->activity_by= Auth::user()->email;
        $activity->activity_by_post = Auth::user()->position;
        $activity->folder_id= '10000';
        $activity->activity= ' Move File to KIV (Keep In View)';
        $activity->save();
   }

    Public function getTemp()
    {
        $folder_name = request('items');
        $new_name = parent::translateFromUtf8(trim($folder_name));        
        $old_file = parent::getCurrentPath($new_name);
        $new_path = public_path().'/docs/files/trash/'.$new_name;
        $move     = File::copyDirectory($old_file, $new_path);
        $delete   = File::deleteDirectory($old_file);

        // delete file from the database...
        $folder = Folder::where('folder_no', $folder_name)->first();
        
        $activity = new Activity;
        $activity->activity_by= Auth::user()->email;
        $activity->activity_by_post = Auth::user()->position;        
        $activity->folder_id = $folder->id;               
        $activity->fileinfo  = $new_name;
        $activity->activity  = 'One folder deleted from system';
        $activity->save();

        // delete file from database
        //DB::table('folders')->where('folder_no', $new_name)->delete();
        Folder::where('folder_no', $folder_name)->delete();
        Activity::where('element_id', $folder->id)->delete(); // delete all activities associated to the folder

        //Folder::findOrFail($folder->id)->delete();

        Flash::success('One Folder deleted');
        return redirect()->back();
   }
}
