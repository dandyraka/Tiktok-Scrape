<?php
require __DIR__.'/../vendor/autoload.php';

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

echo "== TikTok Scrape ==\n    Profile Info\n\n";
echo "TikTok Username : "; //zeejkt48
$user = trim(fgets(STDIN));

$client = new Client([
    'headers' => [
        'Authority'                 => 'www.tiktok.com',
        'Cache-Control'             => 'max-age=0',
        'Upgrade-Insecure-Requests' => '1',
        'Sec-Fetch-User'            => '?1',
        'Accept'                    => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
        'Sec-Fetch-Site'            => 'same-origin',
        'Sec-Fetch-Mode'            => 'navigate',
        'Accept-Encoding'           => 'gzip, deflate, br',
        'Accept-Language'           => 'id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7',
        'Cookie'                    => 'tt_webid_v2=6789476397943735810; _ga=GA1.2.548553945.1580798167; _gid=GA1.2.1740132949.1580798167; ak_bmsc=7E7BFA3FE2DB45538F5C670D1B5CFABF1734AB5DD3570000D710395E77F73C53~plUQuZ+P/munU/F3mhPB7HhfGT8vFm/oV05ttVAwa9KUr+9qxswM6InumaNM7OXbZZOT9X8eH/d+VtZ9G/W08CBh7pDPBV+TtLZ47MctWSC3/nC602Apc1D8TdnebK+6MWmm0G82LultPwU89X2Ru1wH8eG8Bt/ZeKgC3R1eqWhjijVCF0owKtVbEJrPJLl/8lEDdOf93gZ4fbgsMi3vkBjG1ZazLqfp9hX2Q9ggcGow/FkOFOHv0lXSXpY5nv65+K; SLARDAR_WEB_ID=4106a938-ebf0-4a1c-a010-adb9fa0b1dda; bm_sv=EAD7D2E6417EAE0D0AFF43DEB121B065~7eHw00etfMRMucI9Fjl3JGE2ia4Xd+FLJfVgO3XEYsbO37VdYpHstvd0wTjv8Tlwie3+Kj4hy2gBHG0XZ9tgBzC54AuP01ytn2538jdFS9wJGw3mvE/nFIAYg28XoYYVPpZ89QxLSBqdAXc5LvlpZTLYrDM3yKhKWx/XHj66koI=',
        'User-Agent'                => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36',
    ],
]);

$response = $client->request('GET', 'https://www.tiktok.com/@'.$user);
$body = $response->getBody()->getContents();

$crawler = new Crawler($body);
$items = $crawler->filter('script[id="__NEXT_DATA__"]')->html();

$json = json_decode($items);
if(!empty($json->props->pageProps->uniqueId)){
    $username = $json->props->pageProps->uniqueId;
    $secUid = $json->props->pageProps->userData->secUid;
    $userId = $json->props->pageProps->userData->userId;
    $nama = $json->props->pageProps->userData->nickName;
    $avatar = $json->props->pageProps->userData->coversMedium[0];
    $following = $json->props->pageProps->userData->following;
    $followers = $json->props->pageProps->userData->fans;
    $like = $json->props->pageProps->userData->heart;
    $totalVideo = $json->props->pageProps->userData->video;
    $webtoken = $json->query->webtoken;

    echo "\n* Profile Info *\nName : ".$nama."\nUsername : ".$username."\nSecUid : ".$secUid."\nUser Id : ".$userId."\nAvatar : ".$avatar."\nFollowing : ".$following."\nFollowers : ".$followers."\nLike Total : ".$like."\nVideo Total : ".$totalVideo;
    echo "\n\n== END ==";
}