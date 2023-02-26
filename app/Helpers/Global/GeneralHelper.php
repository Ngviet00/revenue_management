<?php

use App\Domains\CourseOptions\Models\Other;
use App\Domains\Orders\Models\Order;
use App\Domains\Stores\Models\Store;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use ProtoneMedia\LaravelFFMpeg\Filters\TileFactory;
use FFMpeg\Format\Video\X264;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Coordinate\TimeCode;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use App\Domains\ManageGirl\Models\ManageGirl;

if (!function_exists('appName')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function appName()
    {
        return config('app.name', 'Oricus');
    }
}

if (!function_exists('carbon')) {
    /**
     * Create a new Carbon instance from a time.
     *
     * @param $time
     * @return Carbon
     *
     * @throws Exception
     */
    function carbon($time)
    {
        return new Carbon($time);
    }
}

if (!function_exists('homeRoute')) {
    /**
     * Return the route to the "home" page depending on authentication/authorization status.
     *
     * @return string
     */
    function homeRoute()
    {
        if (auth()->check()) {
            if (auth()->user()->isAdmin()) {
                return 'admin.dashboard';
            }

            if (auth()->user()->isUser()) {
                return 'frontend.user.dashboard';
            }
        }

        return 'frontend.index';
    }
}

if (!function_exists('homeRouteAdmin')) {
    /**
     * Return the route to the "home" page depending on authentication/authorization status.
     *
     * @return string
     */
    function homeRouteAdmin()
    {
        if (auth()->check()) {
            if (auth()->user()->isAdmin() || auth()->user()->isLeader() || auth()->user()->isList()) {
                return 'admin.dashboard';
            }

            if (auth()->user()->isReceptionist()) {
                return 'admin.order.redirect-to-create';
            }
        }

        return 'admin.login';
    }
}

if (!function_exists('formatDateJP')) {
    /**
     * @param $date
     * @return mixed|string
     */
    function formatDateJP($date)
    {
        if ($date) {
            $newDate = Carbon::create($date);

            $date = $newDate->format('Y-m/d');

            $date = str_replace('-', '年', $date);
            $date = str_replace('/', '月', $date);
            $date .= "日";

            return $date;
        }

        return '';
    }
}

if (!function_exists('formatDateJPExtend')) {
    /**
     * @param $date
     * @return mixed|string
     */
    function formatDateJPExtend($date)
    {
        if ($date) {
            $newDate = Carbon::create($date);

            $date = $newDate->format('Y-m/d H:i');

            $date = str_replace('-', '年', $date);
            $date = str_replace('/', '月', $date);
            $date = str_replace(' ', '日　', $date);

            return $date;
        }

        return '';
    }
}

if (!function_exists('escape_like')) {
    /**
     * @param $string
     * @return string|string[]
     */
    function escape_like($string)
    {
        $search = array('%', '');
        $replace = array('\%', "\\");
        return str_replace($search, $replace, $string);
    }
}

if (!function_exists('getMonthYearOptionOfPaymentConditionFilter')) {
    /**
     * @param $string
     * @return string|string[]
     */
    function getMonthYearOptionOfPaymentConditionFilter()
    {
        $option = [];

        $nextMonth = Carbon::now()->startOfMonth()->addMonth();
        $month = Carbon::now()->startOfMonth()->subMonths(10);
        while ($month->lt($nextMonth)) {
            $option[] = $month->year . '年' . ($month->month < 10 ? '0' . $month->month : $month->month) . '月';
            $month->addMonth();
        }

        $optionVal = $nextMonth->year . '年' . ($nextMonth->month < 10 ? '0' . $nextMonth->month : $nextMonth->month) . '月';

        if (!in_array($optionVal, $option)) $option[] = $optionVal;

        return $option;
    }
}

if (!function_exists('getListNameOptions')) {
    /**
     * @param $string
     * @return string|string[]
     */
    function getListNameOptions($data)
    {
        $name = '';
        $isFirstOption = true;
        if ($data->options) {
            foreach ($data->options as $item) {
                if ($isFirstOption) {
                    $name .= $item['name'];
                    $isFirstOption = false;
                } else {
                    $name .= '、' . $item['name'];
                }
            }
        }

        return $name ? $name : 'なし';
    }
}

if (!function_exists('getListNameOptionsOrder')) {
    /**
     * @param $string
     * @return string|string[]
     */
    function getListNameOptionsOrder($data, $status)
    {
        $option = '';
        $isFirstOption = true;
        if ($data->options) {
            foreach ($data->options as $item) {
                if ($item['no_back'] == $status) {
                    if ($isFirstOption) {
                        $option .= $item['name'];
                        $isFirstOption = false;
                    } else {
                        $option .= '、' . $item['name'];
                    }
                }
            }
        }
        return $option ?? '';
    }
}

if (!function_exists('getListNameOptionsOrderPrint')) {
    /**
     * @param $string
     * @return string|string[]
     */
    function getListNameOptionsOrderPrint($data, $status)
    {
        $option = '';
        $isFirstOption = true;
        if ($data->options) {
            foreach ($data->options as $item) {
                if ($item['no_back'] == $status) {
                    if ($status == null) {
                        if ($isFirstOption) {
                            $option .= $item['name'];
                            $isFirstOption = false;
                        } else {
                            $option .= '、' . $item['name'];
                        }
                    } else {
                        if ($isFirstOption) {
                            $option .= $item['name']  . '（無し）';
                            $isFirstOption = false;
                        } else {
                            $option .= '、' . $item['name'] . '（無し）';
                        }
                    }
                }
            }
        }
        return $option ?? '';
    }
}

if (!function_exists('calReportCashRevenue')) {
    /**
     * @param $data
     * @return string|string[]
     */
    function calReportCashRevenue($data)
    {
        return $data['total_revenue'] - $data['total_revenue_by_card'] - $data['total_salary_for_girl'] - $data['total_fee'];
    }
}

if (!function_exists('japaneseFormatYearMonthToDatabaseFormat')) {
    /**
     * @param $japaneseYearMonth
     * @return string|string[]
     */
    function japaneseFormatYearMonthToDatabaseFormat($japaneseYearMonth): array|string
    {
        return str_replace(['年', '月'], ['-', ''], $japaneseYearMonth);
    }
}

if (!function_exists('displayTotalOfAllByGirl')) {
    /**
     * @param $data
     * @return string|string[]
     */
    function displayTotalOfAllByGirl($backOptionData, $totalByRowData, $girlId)
    {
        $totalOfCoursePrice = isset($totalByRowData[$girlId]) ? $totalByRowData[$girlId]['total_price'] : 0;
        $totalBackAssignPrice = isset($backOptionData[$girlId]['back_assign']) ? $backOptionData[$girlId]['back_assign']['total_price'] : 0;
        $totalExceptOption2Price = isset($backOptionData[$girlId]['except_option_2']) ? $backOptionData[$girlId]['except_option_2']['total_price'] : 0;
        $totalOnlyOption2Price = isset($backOptionData[$girlId]['only_option_2']) ? $backOptionData[$girlId]['only_option_2']['total_price'] : 0;

        return $totalOfCoursePrice + $totalBackAssignPrice + $totalExceptOption2Price + $totalOnlyOption2Price;
    }
}

if (!function_exists('displayTotalOfAll')) {
    /**
     * @param $data
     * @return string|string[]
     */
    function displayTotalOfAll($totalOfAllCourse, $totalOfAllBackOption)
    {
        $totalOfCoursePrice = isset($totalOfAllCourse['total_price']) ? $totalOfAllCourse['total_price'] : 0;
        $totalBackAssignPrice = isset($totalOfAllBackOption['back_assign']['total_price']) ? $totalOfAllBackOption['back_assign']['total_price'] : 0;
        $totalExceptOption2Price = isset($totalOfAllBackOption['except_option_2']['total_price']) ? $totalOfAllBackOption['except_option_2']['total_price'] : 0;
        $totalOnlyOption2Price = isset($totalOfAllBackOption['only_option_2']['total_price']) ? $totalOfAllBackOption['only_option_2']['total_price'] : 0;

        return $totalOfCoursePrice + $totalBackAssignPrice + $totalExceptOption2Price + $totalOnlyOption2Price;
    }
}

if (!function_exists('formatYearMonth')) {
    /**
     * @param $date
     * @return string
     */
    function formatYearMonth($date)
    {
        $dateFormat = Carbon::parse($date);
        $current  = date("N", mktime($dateFormat->hour, $dateFormat->minute, $dateFormat->second, $dateFormat->month, $dateFormat->day, $dateFormat->year));
        $dys = array("", "月", "火", "水", "木", "金", "土", "日");
        $result = $dys[$current];
        return date_format(date_create($date), 'm/d') . '（' . $result . '）';
    }
}

if (!function_exists('countNomination')) {
    /**
     * @param $orders
     * @param $other
     * @return int
     */
    function countNomination($orders, $other)
    {
        $orders =  collect($orders)->pluck('other_id');
        $result = array_filter($orders->toArray(), function ($value) use ($other) {
            return in_array($value, $other->toArray());
        });
        return count($result);
    }
}

if (!function_exists('checkOrderApproved')) {
    /**
     * @param $orders
     * @return array
     */
    function checkOrderApproved($orders)
    {
        $orders =  collect($orders)->pluck('approved_at');
        $result = array_filter($orders->toArray(), function ($value) {
            return $value == null || empty($value);
        });
        return $result;
    }
}
if (!function_exists('getOptionListStr')) {
    /**
     * @param $data
     * @return string|string[]
     */
    function getOptionListStr($options)
    {
        $optionStr = '';
        if (count($options) == 0)  return 'なし';

        foreach ($options as $key => $option) {
            if ($option['no_back'] != 'on' && strlen($option['name']) > 0) {
                $optionStr .= $option['name'] . ', ';
            }
        }

        return substr($optionStr, 0, -2);
    }
}

if (!function_exists('getOptionDate')) {
    /**
     * @return array
     */
    function getOptionDate(): array
    {
        $date = Carbon::now();
        $rs[Carbon::now()->format('Y-m')] = Carbon::now()->format('Y年m月');

        for ($i = 1; $i < 12; $i++) {
            $subMonth = $date->subMonth();

            $rs[$subMonth->format('Y-m')] = $subMonth->format('Y年m月');
        }

        return $rs;
    }
}

if (!function_exists('getDateQueryOrders')) {
    /**
     * @param $date
     * @return string[]
     */
    function getDateQueryOrders($date)
    {
        $dateFrom = Carbon::create($date)->format('Y-m-d 05:00:00');
        $dateTo = Carbon::create($date)->addDay()->format('Y-m-d 04:59:59');
        return [$dateFrom, $dateTo];
    }
}

if (!function_exists('getDateSaveDataDaily')) {
    /**
     * @param $date
     * @return string
     */
    function getDateSaveDataDaily($date)
    {
        $date = Carbon::create($date);
        $now =  Carbon::now()->format('Y-m-d');
        $current = Carbon::now()->format('H:i:s');

        if ($date->format('Y-m-d') == $now && $current < '05:00:00') {
            $d = $date->subDay();
        } else {
            $d = $date;
        }

        return $d->format('Y-m-d');
    }
}

if (!function_exists('getDateSaveDataOrder')) {
    /**
     * @return string
     */
    function getDateSaveDataOrder()
    {
        $date = Carbon::today();
        $current = Carbon::now()->format('H:i:s');

        if ($current < '05:00:00') {
            $d = $date->subDay();
        } else {
            $d = $date;
        }

        return $d->format('Y-m-d');
    }
}

if (!function_exists('getDateSaveOrder')) {
    /**
     * @param $created_at
     * @return string
     */
    function getDateSaveOrder($created_at): string
    {
        $date = Carbon::create($created_at);
        $current = Carbon::create($created_at)->format('H:i:s');

        if ($current < '05:00:00') {
            $date = $date->subDay();
        }

        return $date->format('Y-m-d');
    }
}

if (!function_exists('getDateGirlCoursePrice')) {
    /**
     * @param $created_at
     * @return string
     */
    function getDateGirlCoursePrice($created_at): string
    {
        $date = Carbon::create($created_at);
        $time = Carbon::create($created_at)->format('H:i:s');

        if ($time < '05:00:00') {
            $date = $date->subDay();
        }
        return $date->format('Y/m');
    }
}

if (!function_exists('generateRouteSSL')) {
    /**
     * @return string
     */
    function generateRouteSSL($url)
    {
        if (config('constant.APP_ENV') === 'production') {
            return 'https://' . $url;
        }

        return 'http://' . $url;
    }
}

if (!function_exists('isMenuActive')) {
    /**
     * @return string
     */
    function isMenuActive($slug)
    {
        $url = $slug;
        if (config('constant.APP_ENV') === 'local') {
            $url = 'admin/' . $url;
        }
        if (Request::is($url)) {
            return true;
        }

        return false;
    }
}

if (!function_exists('getDataFromArrayByField')) {
    /**
     * @return string
     */
    function getDataFromArrayByField($array, $field)
    {
        return array_key_exists($field, $array) ? $array[$field] : null;
    }
}

if (!function_exists('saveImageToStorage')) {
    function saveImageToStorage($fileImage, $typeImage, $folder = "", $pathLocal = "", $pathS3 = "", $img = NULL)
    {
        $pathS3 = $pathS3 . $folder .'temporary_file/';
        $pathLocal = $pathLocal . $folder  . 'temporary_file/';
        $imgName = Str::random(8) . time();
        $fullnameFile = $imgName. '.' . $fileImage->extension();
        $idGirlTopic = session()->get("girl_topic_id") ?? null;
        if (!$idGirlTopic) {
            abort(
                302, '',
                ['Location' => route('admin.site-store.manage-girl.tab1.create-info-girl')]
            );
        }
        if ($typeImage == config("constant.TYPE_IMAGE_TOPIC.THUMBNAIL")) { $fullnameFile = "thumbnails".$idGirlTopic.".jpg"; }
        if ($typeImage == config("constant.TYPE_IMAGE_TOPIC.VIDEO")) { $fullnameFile = "videos_" . $idGirlTopic. '.mp4'; }

        $mime = $fileImage->getMimeType();
        deleteTemporaryImageInStorage($pathS3 . "thumbnails". $idGirlTopic .".jpg");
        if (strstr($mime, "video/")) {
            $content = file_get_contents($fileImage->getRealPath());
            if (env('AWS_BUCKET')) {
                Storage::disk('s3')->put($pathS3 . $fullnameFile, $content);
                saveThumbnailsOfVideo($pathS3 . $fullnameFile, $pathS3 . "thumbnails". $idGirlTopic .".jpg", "s3");
                return $pathS3 . $fullnameFile;
            } else {
                Storage::disk('public')->put($pathLocal . $fullnameFile, $content);
                saveThumbnailsOfVideo($pathLocal . $fullnameFile, $pathLocal . "thumbnails". $idGirlTopic .".jpg", "public");
                return $pathLocal . $fullnameFile;
            }
        } else if (strstr($mime, "image/")) {
            if (!$img) $img = Image::make($fileImage->path());
            if (env('AWS_BUCKET')) {
                Storage::disk('s3')->put($pathS3 . $fullnameFile, $img->save());
                return $pathS3 . $fullnameFile;
            } else {
                Storage::disk('public')->put($pathLocal . $fullnameFile, $img->save());
                return $pathLocal . $fullnameFile;
            }
        }
    }
}

if (!function_exists('resizeVideoAndSaveFile'))
{
    function resizeVideoAndSaveFile($file, $disk, $pathSave)
    {
        $lowBitrateFormat = (new X264('libmp3lame', 'libx264'))->setKiloBitrate(2000);
        FFMpeg::fromDisk($disk)
            ->open($file)
            ->addFilter(function ($filters) {
                        $filters->resize(new Dimension(640, 360));
            })
            ->export()
            ->toDisk($disk)
            ->inFormat($lowBitrateFormat)
        ->save($pathSave);

        return $pathSave;
    }
}

if (!function_exists('saveThumbnailsOfVideo'))
{
    function saveThumbnailsOfVideo($pathFileVideo, $pathSaveThumbnail, $disk)
    {
        if (Storage::disk($disk)->has($pathFileVideo)) {
            FFMPEG::fromDisk($disk)->open($pathFileVideo)
            ->frame(TimeCode::fromSeconds(1))
            ->addFilter(function ($filters) {
                $filters->custom('scale=640:360');
            })
            ->export()
            ->toDisk($disk)
            ->save($pathSaveThumbnail);

            return $pathSaveThumbnail;
        }
    }
}



if (!function_exists('deleteTemporaryImageInStorage')) {
    function deleteTemporaryImageInStorage($fileImage)
    {
        if (env('AWS_BUCKET')) {
            if (Storage::disk('s3')->has($fileImage)) {
                return Storage::disk('s3')->delete($fileImage);
            }
        } else {
            if (Storage::disk('public')->has($fileImage)) {
                return Storage::disk('public')->delete($fileImage);
            }
        }
    }
}

if (!function_exists('moveFileFromTemporaryToFolder')) {
    function moveFileFromTemporaryToFolder($fileImage, $idGirlTopic)
    {
        $oldFile = $fileImage;
        $newfile = str_replace("/temporary_file", "/girl_topic_image/" . $idGirlTopic, $fileImage);

        if (env('AWS_BUCKET')) {
            if (Storage::disk('s3')->has($oldFile)&& $oldFile != $newfile) {
                Storage::disk('s3')->move($oldFile, $newfile);
                return $newfile;
            }
        } else {
            if (Storage::disk('public')->has($oldFile) && $oldFile != $newfile) {
                Storage::disk('public')->move($oldFile, $newfile);
                return $newfile;
            }
        }
    }
}


if (!function_exists('copyFileFromTemporaryToFolder')) {
    function copyFileFromTemporaryToFolder($fileImage, $newPath)
    {
        deleteTemporaryImageInStorage($newPath);
        if (env('AWS_BUCKET')) {
            if (Storage::disk('s3')->has($fileImage)) {
                Storage::disk('s3')->copy($fileImage, $newPath);
                return $newPath;
            }
        } else {
            if (Storage::disk('public')->has($fileImage)) {
                Storage::disk('public')->copy($fileImage, $newPath);
                return $newPath;
            }
        }
    }
}
if (!function_exists('checkImageHasSession')) {
    function checkImageHasSession($arraySession, $imageNo, $typeImage)
    {
        foreach ($arraySession as $index => $image)
        {
            if ($image['order'] == $imageNo && $image['type_image'] == $typeImage)  { return $index ;}
        }

        return false;
    }
}

if (!function_exists('checkImageHasSessionDelete')) {
    function checkImageHasSessionDelete($arraySession, $imageNo, $typeImage, $idElement)
    {
        foreach ($arraySession as $index => $image)
        {
            if ($image['order'] == $imageNo && $image['type_image'] == $typeImage && (array_key_exists("id_element", $image) && $image["id_element"] == $idElement ))  { return $index ;}
        }

        return false;
    }
}

if (!function_exists('getStorageLink')) {
    function getStorageLink($imageFrontTopicUrl)
    {
        if (env('AWS_BUCKET')) {
            return Storage::disk('s3')->url($imageFrontTopicUrl);
        } else {
            return Storage::disk('public')->url($imageFrontTopicUrl);
        }
    }
}

if (!function_exists('getThumbnailOfGirl')) {
    function getThumbnailOfGirl($idGirlTopic)
    {
        $thumbnailUrl = session()->has("data_image_girl_topic_tab2") ? "topics/temporary_file/thumbnails".$idGirlTopic.".jpg" :  "topics/girl_topic_image/".$idGirlTopic."/thumbnails".$idGirlTopic.".jpg";
        if (env('AWS_BUCKET')) {
            return Storage::disk('s3')->url($thumbnailUrl);
        } else {
            return Storage::disk('public')->url($thumbnailUrl);
        }
    }
}

if (!function_exists('getIndexOfArray')) {
    function getIndexOfArray($array, $valueFind, $field)
    {
        foreach ($array as $key => $value) {
            if (array_key_exists($field, $value) && $value[$field] == $valueFind)
            {
                return $key;
            }
        }

        return false;
    }
}

if (!function_exists('getFileNameByURL')) {
    function getFileNameByURL($urlImage)
    {
        $arrayUrl = explode("/",$urlImage);
        return $arrayUrl[count($arrayUrl) - 1];
    }
}

if (!function_exists('getIndexByIdInArray')) {
    function getIndexByIdInArray($id, $dataArray)
    {
        foreach ($dataArray as $key => $image) {
            if (array_key_exists("id", $image) && $image['id'] == $id)
            {
                return $key;
            }
        }

        return false;
    }
}

if (!function_exists('getSessionByField')) {
    function getSessionByField($sessionKey, $field, $value): ?array
    {
        $session = Session::get($sessionKey);
        return ($session[$field] ?? null) == $value ? $session : null;
    }
}

if (!function_exists('formatYearMonthOfTopic')) {
    /**
     * @param $date
     * @return string
     */
    function formatYearMonthOfTopic($date)
    {
        $dateFormat = Carbon::parse($date);
        $current  = date("N", mktime($dateFormat->hour, $dateFormat->minute, $dateFormat->second, $dateFormat->month, $dateFormat->day, $dateFormat->year));
        $dys = array("", "月", "火", "水", "木", "金", "土", "日");
        $result = $dys[$current];
        return date_format(date_create($date), 'Y/m/d h:i') . '（' . $result . '）';
    }
}

if (!function_exists('getBackgroundColorByCategory')) {
    function getBackgroundColorByCategory($key)
    {
        switch ($key) {
            case 1: {
                return 'bg-ffcc66';
            }
            case 2: {
                return 'bg-5acee7';
            }
            case 3: {
                return 'bg-b4db58';
            }
            default: {
                return 'bg-d5a2f8';
            }
        }
    }
}

if (!function_exists('issetThumbnailInTemporary')) {
    function issetThumbnailInTemporary($fileImage)
    {
        if (env('AWS_BUCKET')) {
            return Storage::disk('s3')->has($fileImage);
        } else {
            return Storage::disk('public')->has($fileImage);
        }
    }
}

if (!function_exists('getPreviousRouteName')) {
    function getPreviousRouteName(): mixed
    {
        return app('router')->getRoutes()
            ->match(app('request')->create(app('url')->previous()))
            ->getName();
    }
}

if (!function_exists('getPriceOptionIncludesTax')) {
    function getPriceOptionIncludesTax($price)
    {
        $priceVat = $price + $price * config('constant.VAT');
        return number_format($priceVat);
    }
}

if (!function_exists('getStartDate')) {
    function getStartDate($dateRange, $isNext = true)
    {
        if ($isNext) {
            return $dateRange->last()->addDay(1);
        }
        return $dateRange->first()->subDay(7);
    }
}

if (!function_exists('isShowBtnChangeWeek')) {
    function isShowBtnChangeWeek($date, $isNext = true): bool
    {
        if ($isNext) {
            $datePass = clone $date;
            return $datePass->subDay(28) <= now()->startOfDay();
        }
        return $date >= now()->startOfDay();
    }
}

if (!function_exists('blurImage')) {
    function blurImage($path)
    {
        $disk = config('filesystems.disks.s3.bucket') ? "s3" : "public";

        // header('Content-type: image/jpeg');
        if (Storage::disk($disk)->exists($path)) {
            $file = Storage::disk($disk)->get($path);

            $img = new Imagick();
            $img -> readImageBlob($file);

            // Use gaussianBlurImage function
            $img->blurImage(100, 30);
            $type = 'png';
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($img);
            // Display the output image

            return $base64;
        }

        return asset('assets/images/no-image-girl.png');
    }
}

if (!function_exists('infoGirlHP')) {
    function infoGirlHP($girlHP)
    {
        $str = '';
        $array = $girlHP->only(['height', 'bust', 'waist', 'hip']);
        foreach ($array as $key => $value) {
            if (!empty($str) && mb_substr($str, -1) != '・' && $value != null) {
                $str .= '・';
            }
            if (!is_null($value)) {
                switch ($key) {
                    case 'height':
                        $str .= 'T' . $girlHP->height;
                        break;
                    case 'bust':
                        $str .= 'B' .  $girlHP->bust;
                        $str .= $girlHP->uint_bust ? '(' . config('constant.GIRL_TAB1_UNIT_BUST')[$girlHP->uint_bust] . ')' : '';
                        break;
                    case 'waist':
                        $str .= 'W' . $girlHP->waist;
                        break;
                    case 'hip':
                        $str .= 'H' . $girlHP->hip;
                        break;
                    default:
                        break;
                }
            }
        }
        return $str;
    }
}

if (!function_exists('getMessageOfMatrixSetting')) {
    function getMessageOfMatrixSetting($id)
    {
        $girlTopic = ManageGirl::where('id', $id)->first();

        if (isset($girlTopic) && $girlTopic->linkage == 1){
            switch ($girlTopic->girl->status ?? '') {
                case 2: {
                    return 'この女の子は停止中になっているため、編集できません。';
                }
                case 3: {
                    return 'この女の子は退店になっているため、編集できません。';
                }
                default: {
                    return '';
                }
            }
        }
        return '';
    }
}

if (!function_exists('isEligibleForTimekeeping')) {
    function isEligibleForTimekeeping(string $startStore, string $endStore, string $startGirl, string $endGirl)
    {
        $totalTime = 0;
        if ($endStore < $startStore) {
            $stores = [['start' => $startStore, 'end' => '23:59'], ['start' => '00:00', 'end' => $endStore]];
        } else {
            $stores = [['start' => $startStore,  'end' => $endStore]];
        }
        if ($endGirl < $startGirl) {
            $girls = [['start' => $startGirl, 'end' => '23:59'], ['start' => '00:00', 'end' => $endGirl]];
        } else {
            $girls = [['start' => $startGirl, 'end' => $endGirl]];
        }
        if ($endStore < $startStore && $endGirl < $startGirl) {
            $totalTime = 1;
        }
        foreach ($girls as $key => $girl) {
            foreach ($stores as $k => $store) {
                $totalTime += calculateOverlap($store['start'], $store['end'], $girl['start'], $girl['end']);
            }
        }
        return $totalTime >= 120;
    }
}

if (!function_exists('calculateOverlap')) {
    function calculateOverlap($startShift, $endShift, $startWork, $endWork)
    {
        $startShift = Carbon::parse($startShift);
        $endShift = Carbon::parse($endShift);
        $startWork = Carbon::parse($startWork);
        $endWork = Carbon::parse($endWork);
        $time = $startWork->max($startShift)->min($endShift)->diffInMinutes($startWork->max($endWork)->min($endShift), false);
        return $time > 0 ? $time : 0;
    }
}

if (!function_exists('saveFileToStorage')) {
    function saveFileToStorage($path, $file, $folder = "")
    {
        if (env('AWS_BUCKET')) {
            return Storage::disk('s3')->put($folder . $path, $file);
        } else {
            return Storage::disk('public')->put($folder . $path, $file);
        }
    }
}

if (!function_exists('basicAuth')) {
    function basicAuth() : bool
    {
        if (config('constant.BASIC_AUTH.USERNAME') && config('constant.BASIC_AUTH.PASSWORD')) {
            $storeId = (request()->store instanceof Store) ? request()->store->id : request()->store;
            $basicAuth = Cookie::has('basic_auth_store_' . $storeId);

            return $basicAuth;
        }

        return true;
    }
}

if (!function_exists('format_date')) {
    function format_date($format = 'Y/m/d', $str_time, $default = null)
    {
        if ($str_time) {
            $date = date_create($str_time);
            if ($date) {
                return date_format($date, $format);
            }
            return $default;
        }
        return $default;
    }
}

if (! function_exists('includeRouteFiles')) {

    /**
     * @param $folder
     */
    function includeRouteFiles($folder)
    {
        includeFilesInFolder($folder);
    }
}
