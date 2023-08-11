<?php

return [

    /*
    |--------------------------------------------------------------------------
    | NewsAPI Endpoint
    |--------------------------------------------------------------------------
    |
    | The endpoint to fetch the news from the NewsAPI service.
    |
    */

    'endpoint' => env('NEWSAPI_ENDPOINT', 'https://newsapi.org/v2/everything'),

    /*
    |--------------------------------------------------------------------------
    | NewsAPI Key
    |--------------------------------------------------------------------------
    |
    | Your API key to authenticate requests to NewsAPI.
    |
    */

    'key' => env('NEWSAPI_KEY', 'dbc3d39c3e264843b384546a0d75f263'),

    /*
    |--------------------------------------------------------------------------
    | Source to Category Mapping
    |--------------------------------------------------------------------------
    |
    | A mapping of news sources to their respective categories.
    |
    */

    'source_to_category_mapping' => [
        'The Verge' => 'tech',
        'Gizmodo.com' => 'tech',
        'TechCrunch' => 'tech',
        'Bloomberg' => 'finance',
        'Financial Times' => 'finance',
        'ESPN' => 'sports',
        'Sky Sports' => 'sports',
        'CNN Health' => 'health',
        'WebMD' => 'health',
        'Weather.com' => 'weather',
        'BBC Weather' => 'weather',
        'The Wall Street Journal' => 'finance',
        'Engadget' => 'tech',
        'The Next Web' => 'tech',
        'The New York Times' => 'news',
        'BBC News' => 'news',
        'The Washington Post' => 'news',
    ],

];
