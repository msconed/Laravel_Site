<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Replies;
use App\Models\SubCategory;
use App\Models\Topics;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;




class forumController extends Controller
{
    private function reloadPageJS(){echo "<script>window.location.reload();</script>";}
    public function new_topic_create(Request $request)
    {
        $path = $request->input('path2');
        $header = $request->input('header');
        $text = $request->input('text');

        $errors = [];

        if (is_Null($path) or is_Null($header) or is_Null($text)){echo "Заполните все поля";return "";}
        if (strlen($header) < 2) {$errors[] = "Слишком короткий заголовок";}
        if (strlen($text) < 5) {$errors[] = "Слишком короткое сообщение";}

        if (count($errors) > 0){
            foreach ($errors as $err)
            {
                echo "$err<br>";
            }

            echo "";
            return "";
        }

        $formattedPath = json_decode($path, true);
        $category_id = $formattedPath[1];
        $subCat_id = $formattedPath[2];

        $topicIds = Topics::whereRaw('category_id = ?', $category_id)->whereRaw('sub_category_id = ?', $subCat_id)->get('topic_id')->toArray() ?? [];
        $newTopic_id = 1;
        if (count($topicIds) > 0)
        {
            $max = max(array_column($topicIds, 'topic_id'));
            $newTopic_id = $max + 1;
        }

        $new_topic = Topics::create(['category_id' => $category_id,
                                     'sub_category_id' => $subCat_id,
                                     'topic_id' => $newTopic_id,
                                     'header' => $header,
                                     'text' => $text,
                                     'creator_id' => Auth::user()->id
                                     ]);

        if ($new_topic)
        {
            echo "Топик создан";
            $this->reloadPageJS();
        }
        //print_r(Auth::user()->id);
    }

    public function create_reply()
    {
        
    }

    static function getCategories()
    {
        $categoris = Category::whereRaw('is_deleted = ?', 0)->get(['category_id', 'name'])->toArray();
        return $categoris;
       //print_r($categoris);
    }

    static function getSubCategoriesByCategoryID($category_id)
    {
        //$retArray = [];
        $subCategoris = SubCategory::whereRaw('is_deleted = ?', 0)->whereRaw('category_id = ?', $category_id)->get(['sub_category_id', 'category_id', 'name', 'description'])->toArray();
        // Возвращаем только те subcategory, где есть топики
        /*        foreach ($subCategoris as $v)
        {
            $countTopicsInSubCategory = Topics::whereRaw("sub_category_id = ?", $v['sub_category_id'])->
                                                whereRaw("category_id = ?", $v['category_id'])->
                                                get()->toArray() ?? [];
            if (count($countTopicsInSubCategory) > 0)
            {
                $retArray[] = $v;
            }
        }*/
        return $subCategoris;
    }

    static function getTopics($category_id, $subCatrgory_id)
    {
        $topics = Topics::whereRaw('is_deleted = ?', 0)->whereRaw('category_id = ?', $category_id)->whereRaw('sub_category_id = ?', $subCatrgory_id)->get(['*'])->toArray();
        //print_r($subCategoris);
        return $topics;
    }


    static function getReplies()
    {
        $replies = Replies::whereRaw('is_deleted = ?', 0)->get(['*'])->toArray();
        //print_r($subCategoris);
        return $replies;
    }

    static function forumMain()
    {
        $returnArr = [];

        foreach (forumController::getCategories() as $k)
        {
            $subCategories = forumController::getSubCategoriesByCategoryID($k['category_id']);
            
            $returnArr[] = [$k, $subCategories];
        }

        return $returnArr;
    }

    static function getLastTopicById($id=1)
    {
        $topics = Topics::whereRaw('is_deleted = ?', 0)->get(['*'])->last()->toArray();
        //print_r($topics);
        return $topics;
    }

    static function getSubCategoryName($path): string
    {
        $name = SubCategory::whereRaw('category_id = ?', $path[0])->whereRaw('sub_category_id = ?', $path[1])->first();
        return $name['name'];
    }

    static function getAuthorNameByID($id): string
    {
        $name = User::whereRaw('id = ?', $id)->first();
        return $name['name'];
    }

    static function getCategoryName($category_id): string
    {
        $name = Category::whereRaw('category_id = ?', $category_id)->whereRaw('is_deleted = ?', 0)->first();
        return $name['name'];
    }

    static function showTopics($category_id, $subCatrgory_id)
    {
        $topics = forumController::getTopics($category_id, $subCatrgory_id);
        if (count($topics) === 0) {abort(404);}

        $SubCategoryName = forumController::getSubCategoryName([$category_id, $subCatrgory_id]);
        $categoryName = forumController::getCategoryName($category_id);

        $path2 = json_encode(['1' => $category_id, '2' => $subCatrgory_id]);

        return view('forum/topics', ['arr' => $topics, 'path2' => $path2, 'path' => "/forum/$category_id/$subCatrgory_id", 'SubCategoryName' => $SubCategoryName, 'categoryName' => $categoryName]);
    }

    static function getTopicInfoByID($topic_id, $subCatrgory_id)
    {
        $topics = Topics::whereRaw('is_deleted = ?', 0)
                        ->whereRaw('topic_id = ?', $topic_id)
                        ->whereRaw('sub_category_id = ?', $subCatrgory_id)
                        ->get(['*'])->last()->toArray();
        if (count($topics) === 0) {abort(404);}
        return $topics;
    }

    static function getTopicAuthorName($creator_id): string
    {
        $userName = User::whereRaw('id = ?', $creator_id)->first();
        return $userName['name'];
    }

    static function details($category_id, $subCatrgory_id, $topic_id)
    {
        $topic = forumController::getTopicInfoByID($topic_id, $subCatrgory_id);
        if (count($topic) === 0) {abort(404);}

        $authorName = forumController::getTopicAuthorName($topic['creator_id']);
        $categoryName = forumController::getSubCategoryName([$category_id, $subCatrgory_id]);

        $path = "/forum/$category_id/$subCatrgory_id/$topic_id";
        $oldPath = "/forum/$category_id/$subCatrgory_id";
        

        return view('forum.details', ['arr' => $topic, 'oldPath' => $oldPath, 'path' => $path, 'authorName' => $authorName, 'categoryName' => $categoryName]);
    }
}
