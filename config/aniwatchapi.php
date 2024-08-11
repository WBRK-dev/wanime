<?php

return [

    "url" => env("ANIWATCH_API_URL"),
    "frontend_url" => env("FRONTEND_ANIWATCH_API_URL"),
    
    "routes" => [
        "home" => "/anime/home",
        "schedule" => "/anime/schedule",
        "about" => "/anime/info",
        "search" => "/anime/search",
        "episodes" => "/anime/episodes",
        "episode-servers" => "/anime/episode-servers",
        "episode-streaming-links" => "/anime/episode-streaming-links"
    ]

];