<?php namespace App\Http\Controllers\FileManagement;

use Illuminate\Support\Facades\File;

use App\activity;
use DB;

/**
 * Class ItemsController
 */
class ItemsController extends LfmController
{
    /**
     * Get the images to load for a selected folder
     *
     * @return mixed
     */

    private $show_list;

    public function getItems()
    {
        $path = parent::getCurrentPath();
        $sort_type = request('sort_type');

        $keyword = '%'.request('keyword').'%';

        $show_list = request('show_list'); // this is needed so as not to unnecessarily query the database.
        $folders = '';
        $count = '';
        
        if($show_list === "2"){
            $folders = DB::table('folders')->where('search_term', 'like', $keyword)->orwhere('last_comment', 'like', $keyword)->get();
            //$count = DB::select('select * from folders where fold_name like ? ', [$keyword])->count();
            $count = count($folders);
        }

        $files = parent::sortFilesAndDirectories(parent::getFilesWithInfo($path), $sort_type);
        $directories = parent::sortFilesAndDirectories(parent::getDirectories($path), $sort_type);
        $working_dir = parent::getInternalPath($path);

        return [
            'html' => (string)view($this->getView())->with([
                'files'       => $files,
                'directories' => $directories,
				'folders'     => $folders,
                'count'       => $count,
                'working_dir' => $working_dir,
                'items'       => array_merge($directories, $files)
            ]),
            'working_dir' => $working_dir
        ];
    }


    private function getView()
    {
        $view_type = 'grid';
        $show_list = request('show_list');

        if ($show_list === "2") {
            $view_type = 'search';
            return 'registry.' . $view_type . '-view';
        }   
        elseif ($show_list === "1") {
            $view_type = 'list';
        } elseif (is_null($show_list)) {
            $type_key = parent::currentLfmType();
            $startup_view = config('lfm.' . $type_key . 's_startup_view');

            if (in_array($startup_view, ['list', 'grid'])) {
                $view_type = $startup_view;
            }
        }

        return 'registry.' . $view_type . '-view';
    }
}
