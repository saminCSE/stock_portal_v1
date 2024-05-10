<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\NewsPortal;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class BreakingNewsApiController extends Controller
{
    public function News(Request $request)
    {
        $singlenews = $request->q;
        $News =  DB::table('news_portal')
            ->select('id', 'title', 'slug', 'published_date', 'short_description', 'long_description', 'source','source_link','file')
            ->where('slug', '=', $singlenews)
            ->orderBy('published_date', 'DESC')
            ->get();

        $response = array(
            'data' => $News,
            'status' => 'success',
        );
        return response()->json($response);
    }

    public function AllNews(Request $request)
    {
        // $allNews =  DB::table('news_portal')
        // ->select('id','title','slug','published_date', 'short_description', 'source', 'file')
        // ->where('is_published', 1)
        // ->orderBy('id', 'DESC')
        // ->limit(7)
        // ->get();
        try {
            //$totalRecords = DB::table('news_portal')->where('is_published', 1)->count();
            $page = $request->page;
            $limit = 5;
            $offset = ($page -1) * $limit;
            $allNews = DB::table('news_portal')
                ->select('id', 'title', 'slug', 'published_date', 'short_description', 'source','source_link', 'file')
                ->where('is_published', 1)
                ->orderBy('id', 'DESC')
                ->offset($offset)
                ->limit($limit)
                ->get();
            $response = array(
                'data' => $allNews,
                'status' => 'success',
            );
            return response()->json($response);
        } catch (HttpException $e) {
            $response = array(
                'data' => $e->getMessage(),
                'status' => 'error',
            );
            return response()->json($response);
        }
    }

    public function BreakingNews()
    {
        $breakingnews = NewsPortal::select('id', 'title', 'slug')
            ->orderBy('id', 'DESC')
            ->limit(10)
            ->get();
        try {
            $response = array(
                'data' => $breakingnews,
                'status' => 'success',
            );
            return response()->json($response);
        } catch (HttpException $e) {
            $response = array(
                'data' => $e->getMessage(),
                'status' => 'error',
            );
            return response()->json($response);
        }
    }

    public function NewsHighlight()
    {
        $featureNews = DB::table('news_portal')
            ->leftJoin('news_category', 'news_category.id', '=', 'news_portal.news_category')
            ->where('is_published', 1)
            ->where('is_feature_news', 1)
            ->select('news_portal.id', 'news_category.name as category_name', 'news_portal.title', 'news_portal.slug', 'news_portal.published_date', 'news_portal.short_description', 'news_portal.source','news_portal.source_link', 'news_portal.file')
            ->orderBy('news_portal.id', 'DESC')
            ->take(1)
            ->get()->toArray();
        $highligtNews = DB::table('news_portal')
            ->leftJoin('news_category', 'news_category.id', '=', 'news_portal.news_category')
            ->where('is_published', 1)
            ->where('is_highlight_news', 1)
            ->select('news_portal.id', 'news_category.name as category_name', 'news_portal.title', 'news_portal.slug', 'news_portal.published_date', 'news_portal.short_description', 'news_portal.source','news_portal.source_link', 'news_portal.file')
            ->orderBy('news_portal.id', 'DESC')
            ->take(3)
            ->get()->toArray();
        $newshighlight = array_merge($featureNews, $highligtNews);
        try {
            $response = array(
                'data' => $newshighlight,
                'status' => 'success',
            );
            return response()->json($response);
        } catch (HttpException $e) {
            $response = array(
                'data' => $e->getMessage(),
                'status' => 'error',
            );
            return response()->json($response);
        }
    }
    public function newsHighlightCategory()
    {

        $newshighlight = DB::table('news_portal')
            ->leftJoin('news_category', 'news_category.id', '=', 'news_portal.news_category')
            ->where('is_published', 1)
            ->select('news_portal.id', 'news_category.name as category_name', 'news_portal.title', 'news_portal.slug', 'news_portal.published_date', 'news_portal.short_description', 'news_portal.source','news_portal.source_link', 'news_portal.file')
            ->orderBy('news_portal.id', 'DESC')
            ->take(3)
            ->offset(4)
            ->get();
        try {
            $response = array(
                'data' => $newshighlight,
                'status' => 'success',
            );
            return response()->json($response);
        } catch (HttpException $e) {
            $response = array(
                'data' => $e->getMessage(),
                'status' => 'error',
            );
            return response()->json($response);
        }
    }
    public function newsCategory(Request $request)
    {
        $count = $request->input('count', 5);
        $category_id = $request->id;
        $newshighlight = DB::table('news_portal')
            ->leftJoin('news_category', 'news_category.id', '=', 'news_portal.news_category')
            ->select('news_portal.id', 'news_category.name as category_name', 'news_portal.title', 'news_portal.slug', 'news_portal.published_date', 'news_portal.short_description', 'news_portal.source','news_portal.source_link', 'news_portal.file')
            ->where('news_portal.is_published', 1)
            ->where('news_portal.news_category', $category_id)
            ->orderBy('news_portal.id', 'DESC')
            ->take($count)
            ->get();

        $response = array(
            'data' => $newshighlight,
            'status' => 'success',
        );
        return response()->json($response);
    }

    public function CorporateNews(Request $request)
    {
        $count = $request->input('count', 10);
        $corporate_news = DB::table('news_portal')
            ->leftJoin('news_category', 'news_category.id', '=', 'news_portal.news_category')
            ->select('news_portal.id', 'news_category.name as category_name', 'news_portal.title', 'news_portal.slug', 'news_portal.published_date', 'news_portal.short_description', 'news_portal.source','news_portal.source_link', 'news_portal.file')
            ->where('news_portal.is_published', 1)
            ->where('news_portal.news_category',3)
            ->orderBy('news_portal.id', 'DESC')
            ->take($count)
            ->get();

        $response = array(
            'data' => $corporate_news,
            'status' => 'success',
        );
        return response()->json($response);
    }

    public function FinancialNews(Request $request)
    {
        $count = $request->input('count', 10);
        $financial_news = DB::table('news_portal')
            ->leftJoin('news_category', 'news_category.id', '=', 'news_portal.news_category')
            ->select('news_portal.id', 'news_category.name as category_name', 'news_portal.title', 'news_portal.slug', 'news_portal.published_date', 'news_portal.short_description', 'news_portal.source','news_portal.source_link', 'news_portal.file')
            ->where('news_portal.is_published', 1)
            ->where('news_portal.news_category',4)
            ->orderBy('news_portal.id', 'DESC')
            ->take($count)
            ->get();

        $response = array(
            'data' => $financial_news,
            'status' => 'success',
        );
        return response()->json($response);
    }

    public function CorporateNewsSearch(Request $request)
    {
    try {
        
        $search = $request->query('search');
        $corporate_news = DB::table('news_portal')
            ->leftJoin('news_category', 'news_category.id', '=', 'news_portal.news_category')
            ->select('news_portal.id', 'news_category.name as category_name', 'news_portal.title', 'news_portal.slug', 'news_portal.published_date', 'news_portal.short_description', 'news_portal.source','news_portal.source_link', 'news_portal.file')
            ->where('news_portal.is_published', 1)
            ->where('news_portal.news_category',3)
            ->orderBy('news_portal.id', 'DESC');
            

        if (!empty($search)) {
            $corporate_news = $corporate_news->where(function ($query) use ($search) {
                $query->where('news_portal.title', 'like', '%' . $search . '%')
                    ->orWhere('news_portal.slug', 'like', '%' . $search . '%')
                    ->orWhere('news_portal.short_description', 'like', '%' . $search . '%');
            });
        }
        $corporate_news = $corporate_news->get();

        $response = array(
            'data' => $corporate_news,
            'status' => 'success',
        );
        return response()->json($response);
    } catch (HttpException $e) {
        $response = array(
            'data' => $e->getMessage(),
            'status' => 'error',
        );
        return response()->json($response);
    }
}
public function FinancialNewsSearch(Request $request)
    {
    try {
        $search = $request->query('search');

        $financial_news = DB::table('news_portal')
        ->leftJoin('news_category', 'news_category.id', '=', 'news_portal.news_category')
        ->select('news_portal.id', 'news_category.name as category_name', 'news_portal.title', 'news_portal.slug', 'news_portal.published_date', 'news_portal.short_description', 'news_portal.source','news_portal.source_link', 'news_portal.file')
        ->where('news_portal.is_published', 1)
        ->where('news_portal.news_category',4)
        ->orderBy('news_portal.id', 'DESC');

        if (!empty($search)) {
            $financial_news = $financial_news->where(function ($query) use ($search) {
                $query->where('news_portal.title', 'like', '%' . $search . '%')
                    ->orWhere('news_portal.short_description', 'like', '%' . $search . '%');
            });
        }
        $financial_news = $financial_news->get();

        $response = array(
            'data' => $financial_news,
            'status' => 'success',
        );
        return response()->json($response);
    } catch (HttpException $e) {
        $response = array(
            'data' => $e->getMessage(),
            'status' => 'error',
        );
        return response()->json($response);
    }
}

    public function newsCategoryName()
    {
        $newscategory = DB::table('news_category')
            ->where('is_active', 1)
            ->select('news_category.id', 'news_category.name')
            ->orderBy('news_category.id', 'ASC')
            ->get();
        try {
            $response = array(
                'data' => $newscategory,
                'status' => 'success',
            );
            return response()->json($response);
        } catch (HttpException $e) {
            $response = array(
                'data' => $e->getMessage(),
                'status' => 'error',
            );
            return response()->json($response);
        }
    }
}
