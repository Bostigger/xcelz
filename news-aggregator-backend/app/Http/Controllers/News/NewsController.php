<?php



namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    private function getArticlesFromAPI()
    {
        $endpoint = config('newsapi.endpoint');
        $apiKey = config('newsapi.key');
        $response = $this->client->get($endpoint, [
            'query' => [
                'q' => 'news',
                'pageSize' => 50,
                'page' => 1,
                'apiKey' => $apiKey
            ]
        ]);

        return json_decode($response->getBody(), true)['articles'];
    }

    private function categorizeArticles($articles)
    {
        $sourceToCategoryMapping = config('newsapi.source_to_category_mapping');
        $categorizedArticles = [];

        foreach ($articles as $article) {
            $sourceName = $article['source']['name'];
            $category = $sourceToCategoryMapping[$sourceName] ?? 'other';
            $categorizedArticles[$category][] = $article;
        }

        return $categorizedArticles;
    }

    public function fetchAndSaveArticles()
    {
        $articles = $this->getArticlesFromAPI();
        $categorizedArticles = $this->categorizeArticles($articles);

        foreach ($categorizedArticles as $category => $categoryArticles) {
            foreach ($categoryArticles as $article) {
                Article::create([
                    'title' => $article['title'],
                    'author' => $article['author'],
                    'description' => $article['description'],
                    'url' => $article['url'],
                    'source' => $article['source']['name'],
                    'category' => $category,
                    'published_at' => Carbon::parse($article['publishedAt'])
                ]);
            }
        }
    }

    private function applyQueryFilters(Request $request, $query)
    {
        $filters = ['keyword' => 'title', 'category' => 'category', 'source' => 'source', 'date' => 'published_at'];

        foreach ($filters as $input => $column) {
            if ($value = $request->input($input)) {
                $method = ($input == 'keyword') ? 'LIKE' : '=';
                $value = ($input == 'keyword') ? "%{$value}%" : $value;
                $query->where($column, $method, $value);
            }
        }

        return $query;
    }

    public function search(Request $request)
    {
        $query = Article::query();
        $this->applyQueryFilters($request, $query);

        return response()->json($query->paginate(30));
    }

    public function findArticle(Request $request)
    {
        $keyword = $request->input('keyword');

        $articles = Article::query()
            ->where('title', 'LIKE', "%{$keyword}%")
            ->orWhere('category', 'LIKE', "%{$keyword}%")
            ->orWhere('description', 'LIKE', "%{$keyword}%")
            ->get();

        return response()->json($articles);
    }

    public function savePreference(Request $request,$id)
    {
        $user = User::find($id);

        $preferences = ['sources', 'categories', 'authors'];
        foreach ($preferences as $preference) {
            if ($value = $request->input($preference)) {
                $user->$preference = $value;
            }
        }

        $user->save();

        return response(['message' => __('messages.save_preference')], 200); // HTTP 200 OK
    }

    public function fetchArticles(User $user) // Use Route Model Binding
    {
        $query = Article::query();

        $preferences = ['sources' => 'source', 'categories' => 'category', 'authors' => 'author'];
        foreach ($preferences as $attribute => $column) {
            if ($value = $user->$attribute) {
                $query->where($column, $value);
            }
        }

        return response()->json($query->paginate(30));
    }

    public function getAllArticles()
    {
        return response()->json(Article::paginate(30));
    }

    public function getCategory()
    {

        $categories = Article::distinct()->pluck('category')->toArray();

        return response()->json($categories);
    }

    public function getAuthor()
    {
        $authors = Article::distinct()->pluck('author')->toArray();

        return response()->json($authors);
    }
    public function getSource()
    {
        $authors = Article::distinct()->pluck('source')->toArray();

        return response()->json($authors);
    }
}
