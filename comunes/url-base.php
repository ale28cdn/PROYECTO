<?php
if ($_SERVER["HTTP_HOST"] === "www.alwayswithme.es") {
    $url_base = "/proyecto/";
    $url_base_http = "https://www.alwayswithme.es/proyecto/";
} else if ($_SERVER["HTTP_HOST"] === "localhost" || $_SERVER["HTTP_HOST"] === "127.0.0.1:8000") {
    $url_base = "/";
    $url_base_http = "/";
}