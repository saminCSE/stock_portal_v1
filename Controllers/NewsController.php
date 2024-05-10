<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsCategoryModel;
use Illuminate\Support\Carbon;
use App\Http\Controllers\CommonController;
use App\Http\Requests\NewsPortalRequest;
use App\Models\NewsPortal;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Lang;
use App\Repositories\ImageUploadRepo;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = NewsPortal::leftJoin('news_category', 'news_portal.news_category', '=', 'news_category.id')
            ->select('news_portal.id', 'news_category.name as name', 'news_portal.title','news_portal.slug','news_portal.published_date', 'news_portal.long_description', 'news_portal.short_description', 'news_portal.is_published', 'news_portal.source', 'news_portal.file')
            ->orderBy('news_portal.id','desc')
            ->get();
        return view('admin.news.newsportal_list', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $published_date = date('Y-m-d');
        $portalstatus = CommonController::NewsPortal();
        $news_category = NewsCategoryModel::select('id', 'name')->where(['is_active' => 1])->get()->pluck('name', 'id')->prepend('Select', '');
        return view('admin.news.create_newsportal')->with(['portalstatus' => $portalstatus, 'news_category' => $news_category, 'published_date' => $published_date]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewsPortalRequest $request)
    {
        $register = new NewsPortal();
        $register->news_category = $request->news_category;
        $register->title = $request->title;
        $register->slug = $request->slug;
        $register->published_date = $request->published_date;
        $register->short_description = $request->short_description;
        $register->long_description = $request->long_description;
        $register->is_published = $request->is_published;
        $register->source = $request->source;
        $register->source_link= $request->source_link;
        $register->created_by = auth()->user()->id;
        if ($request->hasFile('file')) {
            $image = $request->file;
            $path = public_path() . "/uploads/news/large/";
            $thumb_path = public_path() . "/uploads/news/thumbs/";
            $register->file = ImageUploadRepo::uploadImage($path, $image, '282-132', '', true, $thumb_path);
        }
        if ($request->is_breaking_news== NULL) {
            $register->is_breaking_news = 0;
        } else {
            $register->is_breaking_news = $request->is_breaking_news;
        }
        if ($request->is_highlight_news == NULL){
            $register->is_highlight_news = 0;
        } else {
            $register->is_highlight_news = $request->is_highlight_news;
        }
        if ($request->is_feature_news == NULL) {
            $register->is_feature_news = 0;
        } else {
            $register->is_feature_news = $request->is_feature_news;
        }
        $register->save();
        return redirect('admin/newsportal')->with('status', 'News Create Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(NewsPortal $newsportal)
    {
        // dd($newsportal);
        $published_date = date('Y-m-d');
        $portalnews = NewsPortal::all();
        $portalstatus = CommonController::NewsPortal();
        $news_category = NewsCategoryModel::select('id', 'name')->get()->pluck('name', 'id')->prepend('Select', '');
        return view('admin.news.create_newsportal')->with(['portalstatus' => $portalstatus, 'news_category' => $news_category, 'item' => $newsportal, 'published_date' => $published_date, $portalnews]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NewsPortalRequest $request, $id)
    {
        //
        $register = NewsPortal::find($id);
        $register->news_category = $request->news_category;
        $register->title = $request->title;
        $register->slug = $request->slug;
        $register->published_date = $request->published_date;
        $register->short_description = $request->short_description;
        $register->long_description = $request->long_description;
        $register->is_published = $request->is_published;
        $register->source = $request->source;
        $register->source_link = $request->source_link;
        $register->created_by = auth()->user()->id;
        if ($request->hasFile('file')) {
            $exited_file = $register->file ? $register->file : '';
            $image = $request->file;
            $path = public_path() . "/uploads/news/large/";
            $thumb_path = public_path() . "/uploads/news/thumbs/";
            $register->file = ImageUploadRepo::uploadImage($path, $image, '282-132', $exited_file, true, $thumb_path);
        }
        $register->is_breaking_news = $request->is_breaking_news;
        $register->is_highlight_news = $request->is_highlight_news;
        $register->is_feature_news = $request->is_feature_news;
        $register->update();
        return redirect('admin/newsportal')->with('status', 'News Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(NewsPortal $newsportal)
    {
        ImageUploadRepo::unlinkPath($newsportal->file);
        $newsportal->delete();
        Session::flash('message', Lang::get('messages.Deleted successfully'));
        return redirect()->route('newsportal.index');
    }

    public function NewsCategory()
    {
        $category = NewsCategoryModel::all();
        $isstatus = CommonController::yesno();
        return view('admin.news.create_category', compact('isstatus', 'category'));
    }
    public function CreateCategory(Request $request)
    {
        $request->validate([
            'name'                  => 'required',
            'is_active'              => 'required',
            'name'                  => 'required|unique:news_category',
        ]);
        $register = new NewsCategoryModel();
        $register->name = $request->name;
        $register->created_by = auth()->user()->id;
        $register->is_active = $request->is_active;
        $register->save();
        return redirect()->back()->with('status', 'News Category Create Successfully');
    }
    public function CategoryShow($id)
    {
        $item = NewsCategoryModel::find($id);
        $category = NewsCategoryModel::all();
        $isstatus = CommonController::yesno();
        return view('admin.news.create_category')->with(['isstatus' => $isstatus, 'category' => $category, 'item' => $item]);
    }
    public function UpdateCategory(NewsCategoryModel $category, Request $request, $id)
    {
        $register = NewsCategoryModel::find($id);
        $register->name = $request->name;
        $register->is_active = $request->is_active;
        $register->update();
        return redirect('admin/newscategory/newsCategory')->with('status', 'Category Updated Successfully');
    }
    public function deleteCategory($id)
    {
        $category = NewsCategoryModel::find($id);
        $category->delete();
        return redirect()->back()->with('status', 'Category Delete Successfully.');
    }

    public function ChangeStatus(Request $request)
    {
        $is_published = NewsPortal::find($request->id);
        $is_published->is_published = $request->is_published;
        $is_published->update();
        return response()->json(['success' => 'Status change successfully.']);
    }
}
