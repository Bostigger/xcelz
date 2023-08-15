# DEMO VID

https://github.com/Bostigger/xcelz/assets/52701136/3f3c760e-6434-4ee7-86ec-ee263a071b2e

# API

This document outlines the API routes for a web application. The routes are categorized into authentication, news and articles, and user preferences.
Routes
API Auth Routes

-------------------
Handles user authentication functionalities.

Prefix: /auth

    Login:
        Endpoint: /login
        Method: POST
        Handler: AuthController@Login
    Register:
        Endpoint: /register
        Method: POST
        Handler: AuthController@Register

News and Articles Routes

Handles operations related to fetching, saving, and retrieving news and articles.

Prefix: /news

    Fetch and Save Articles:
        Endpoint: /
        Method: GET
        Handler: NewsController@fetchAndSaveArticles

    Get All Articles:
        Endpoint: /articles
        Method: GET
        Handler: NewsController@getAllArticles

    Search Articles:
        Endpoint: /articles/search
        Method: POST
        Handler: NewsController@search

    Find Article:
        Endpoint: /articles/find
        Method: POST
        Handler: NewsController@findArticle

    Fetch Article By ID:
        Endpoint: /articles/{id}
        Method: GET
        Handler: NewsController@fetchArticles

    Get Category:
        Endpoint: /category
        Method: GET
        Handler: NewsController@getCategory

    Get Author:
        Endpoint: /author
        Method: GET
        Handler: NewsController@getAuthor

    Get Source:
        Endpoint: /source
        Method: GET
        Handler: NewsController@getSource

User Routes

Handles operations related to user-specific preferences.

Prefix: /user

    Save Preference for a User:
        Endpoint: /preference/{id}
        Method: POST
        Handler: NewsController@savePreference



