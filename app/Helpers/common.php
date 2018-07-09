<?php
function menu_tree_ddlist($menu_id, $parent)
{
  $data["languages"] = DB::table('languages')->get();
  foreach ($data["languages"] as $language) {
      if($language->is_default == 1)
      {
          $defaultlanguge = $language->id;
      }
  }
  $menuitems = DB::table('menu_items')->where("menu_id",$menu_id)->orderBy('order')->get();
  $menuitems = json_decode(json_encode($menuitems), true);
  $menu_items = DB::table('menu_items')->where('menu_id',$menu_id)->where('parent',$parent)->where('language_id',$defaultlanguge)->orderBy('order')->get();
  if(count($menu_items) > 0)
  {
      //echo '<div class="dd" id="menuitemsnest">';
      echo '<ol class="dd-list">';
      foreach ($menu_items as $menuitem) {
          $i = 0;
          //if ($i == 0){ echo '<ol class="dd-list">';}
          echo '<li class="dd-item" data-id="'.$menuitem->glue.'">';
          echo '<div class="dd-handle dd3-handle"> </div>';
          echo '<div class="dd3-content">'. $menuitem->link_text;
          echo '<div style="float:right; margin-top:-2px; margin-right:-5px;">';
                  echo '<a href="javascript:void(0)" onclick=javascript:$("#editmenu'.$menuitem->id.'").toggle() class="btn btn-xs blue">';
                      echo '<i class="fa fa-edit"></i>';
                  echo '</a>';
                  echo '<a href="'.url('/admin/menu/detelemenuitem/'.$menuitem->glue.'/'.$menuitem->menu_id).'" data-toggle="modal" class="btn btn-xs red">';
                      echo '<i class="fa fa-times"></i>';
                  echo '</a>';
              echo '</div>';
          echo '</div>';
          echo '<div class="panel-body well" id="editmenu'.$menuitem->id.'" style="display:none">';
          echo '<div class="tabbable tabbable-tabdrop">';
              echo '<ul class="nav nav-tabs" style="margin-bottom:0px">';
                  foreach($data["languages"] as $language){
                  echo '<li ';
                   if($language->is_default == 1) { echo 'class=active'; }
                  echo '>'; 
                  echo '<a href="#fieldtab'.$menuitem->id.$language->id.'" data-toggle="tab">'.ucfirst($language->language).'</a>';
                  echo '</li>';
                  }
              echo '</ul>';
              echo '<div class="tab-content bg-white" style="padding:20px">';
              foreach($data["languages"] as $language){
                  $menuitem_lang = searcharrayby2keyvalue($menuitems, 'language_id', $language->id, 'glue', $menuitem->glue);
                  if(count($menuitem_lang) == 0)
                  {
                        $menuitem_lang[0]["url"] = $menuitem_lang_last[0]["url"];
                        $menuitem_lang[0]["type"] = $menuitem_lang_last[0]["type"];
                        $menuitem_lang[0]["link_text"] = $menuitem_lang_last[0]["link_text"];
                  }else{
                        $menuitem_lang_last[0]["url"] = $menuitem_lang[0]["url"];
                        $menuitem_lang_last[0]["type"] = $menuitem_lang[0]["type"];
                        $menuitem_lang_last[0]["link_text"] = $menuitem_lang[0]["link_text"];      
                  }
                  echo '<div class="tab-pane ';
                  if($language->is_default == 1) { echo 'active'; }
                  echo '" id="fieldtab'.$menuitem->id.$language->id.'">';
                    echo '<div class="form-group">';
                        echo '<label class="col-md-3 control-label">URL</label>';
                        echo '<div class="col-md-9">';
                            echo '<input type="text" name="url_'.$menuitem->glue.'_'.$language->id.'" class="form-control" placeholder="Enter Url" value="'.$menuitem_lang[0]["url"].'"';
                            //if($menuitem_lang[0]['type'] != "custom"){ echo 'readonly'; }
                            echo '>';
                        echo '</div>';
                    echo '</div>';
                    echo '<div class="form-group">';
                        echo '<label class="col-md-3 control-label">Link text</label>';
                        echo '<div class="col-md-9">';
                            echo '<input type="text" class="form-control" value="'.$menuitem_lang[0]["link_text"].'" name="link_text_'.$menuitem->glue.'_'.$language->id.'">';
                        echo '</div>';
                    echo '</div>';
                  echo '</div>';
              }
          echo '</div>';
          echo '</div>';
          echo '<div class="row">';
              echo '<br/>';
              echo '<div class="col-md-12">';
              echo '<div class="form-group">';
                  echo '<label class="col-md-3 control-label">Icon</label>';
                  echo '<div class="col-md-9">';
                      echo '<select class="bs-select form-control" data-live-search="true" data-size="8" name="icon_'.$menuitem->glue.'">';
                          echo '<option value="">None</option>';
                          $iconlist = faiconslist();
                          foreach($iconlist as $icon){
                          echo '<option value="'.$icon.'"';
                          if($menuitem->icon == $icon) { echo 'selected="selected"';}
                          echo ' data-icon="fa fa-'.$icon.'">'. $icon.'</option>';
                          }
                      echo '</select>';
                  echo '</div>';
              echo '</div>';
              echo '<div class="form-group ';
              if($menuitem->parent == 0){ echo 'show'; }else { echo 'hide'; }
              echo '">';
                  echo '<label class="col-md-3 control-label">Is Megamenu</label>';
                  echo '<div class="col-md-9">';
                      echo '<input type="checkbox" name="is_megamenu_'.$menuitem->glue.'" class="make-switch" value="Yes" data-on-color="success" data-off-color="default" data-on-text="&nbsp;Yes&nbsp;" data-off-text="&nbsp;No&nbsp;"';
                      if($menuitem->is_megamenu == 'Yes'){ echo 'checked'; }
                      echo '>';
                  echo '</div>';
              echo '</div>';
              echo '<div class="form-group">';
                  echo '<label class="col-md-3 control-label"></label>';
                  echo '<div class="col-md-9">';
                      echo '<button onclick=$("#editmenu'.$menuitem->id.'").toggle() type="button" class="btn btn-primary btn-sm">OK</button> <button onclick=$("#editmenu'.$menuitem->id.'").toggle() type="button" class="btn btn-default btn-sm">Cancel</button>';
                  echo '</div>';
              echo '</div>';
              echo '</div>';
          echo '</div>';
          echo '</div>';
              menu_tree_ddlist($menu_id, $menuitem->glue);
          echo '</li>';
          $i++;
          //if ($i > 0){ echo '</ol>';}
      }
      echo '</ol>';
      //echo "</div>";
  }
  //return $menu_tree;
}
function searcharraybykeyvalue($array, $key, $value)
{
    $results = array();


    if (is_array($array)) {
        if (isset($array[$key]) && $array[$key] == $value) {
            $results[] = $array;
        }

        foreach ($array as $subarray) {
            $results = array_merge($results, searcharraybykeyvalue($subarray, $key, $value));
        }
    }

    return $results;
}

function searcharrayby2keyvalue($array, $key1, $value1, $key2, $value2)
{
    $results = array();


    if (is_array($array)) {
        if (isset($array[$key1]) && isset($array[$key2]) && $array[$key1] == $value1 && $array[$key2] == $value2) {
            $results[] = $array;
            
        }

        foreach ($array as $subarray) {
            $results = array_merge($results, searcharrayby2keyvalue($subarray, $key1, $value1, $key2, $value2));
        }
    }

    return $results;
}

function objectToArray($d) 
{
    if (is_object($d)) {
        // Gets the properties of the given object
        // with get_object_vars function
        $d = get_object_vars($d);
    }

    if (is_array($d)) {
        /*
        * Return array converted to object
        * Using __FUNCTION__ (Magic constant)
        * for recursive call
        */
        return array_map(__FUNCTION__, $d);
    } else {
        // Return array
        return $d;
    }
}
function yandexlanglist()
{
  return array(
      "az" => "Azerbaijan",
      "ml" => "Malayalam",
      "sq" => "Albanian",
      "mt" => "Maltese",
      "am" => "Amharic",
      "mk" => "Macedonian",
      "en" => "English",
      "mi" => "Maori",
      "ar" => "Arabic",
      "mr" => "Marathi",
      "hy" => "Armenian",
      "mhr" => "Mari",
      "af" => "Afrikaans",
      "mn" => "Mongolian",
      "eu" => "Basque",
      "de" => "German",
      "ba" => "Bashkir",
      "ne" => "Nepali",
      "be" => "Belarusian",
      "no" => "Norwegian",
      "bn" => "Bengali",
      "pa" => "Punjabi",
      "my" => "Burmese",
      "pap" => "Papiamento",
      "bg" => "Bulgarian",
      "fa" => "Persian",
      "bs" => "Bosnian",
      "pl" => "Polish",
      "cy" => "Welsh",
      "pt" => "Portuguese",
      "hu" => "Hungarian",
      "ro" => "Romanian",
      "vi" => "Vietnamese",
      "ru" => "Russian",
      "ht" => "Haitian",
      "ceb" => "Cebuano",
      "gl" => "Galician",
      "sr" => "Serbian",
      "nl" => "Dutch",
      "si" => "Sinhala",
      "Mari" => "Hill  mrj",
      "sk" => "Slovakian",
      "el" => "Greek",
      "sl" => "Slovenian",
      "ka" => "Georgian",
      "sw" => "Swahili",
      "gu" => "Gujarati",
      "su" => "Sundanese",
      "da" => "Danish",
      "tg" => "Tajik",
      "he" => "Hebrew",
      "th" => "Thai",
      "yi" => "Yiddish",
      "tl" => "Tagalog",
      "id" => "Indonesian",
      "ta" => "Tamil",
      "ga" => "Irish",
      "tt" => "Tatar",
      "it" => "Italian",
      "te" => "Telugu",
      "is" => "Icelandic",
      "tr" => "Turkish",
      "es" => "Spanish",
      "udm" => "Udmurt",
      "kk" => "Kazakh",
      "uz" => "Uzbek",
      "kn" => "Kannada",
      "uk" => "Ukrainian",
      "ca" => "Catalan",
      "ur" => "Urdu",
      "ky" => "Kyrgyz",
      "fi" => "Finnish",
      "zh" => "Chinese",
      "fr" => "French",
      "ko" => "Korean",
      "hi" => "Hindi",
      "xh" => "Xhosa",
      "hr" => "Croatian",
      "km" => "Khmer",
      "cs" => "Czech",
      "lo" => "Laotian",
      "sv" => "Swedish",
      "la" => "Latin",
      "gd" => "Scottish",
      "lv" => "Latvian",
      "et" => "Estonian",
      "lt" => "Lithuanian",
      "eo" => "Esperanto",
      "lb" => "Luxembourgish",
      "jv" => "Javanese",
      "mg" => "Malagasy",
      "ja" => "Japanese",
      "ms" => "Malay"
    );  
}
function faiconslist(){
    return array(
            "500px",
            "amazon",
            "balance-scale",
            "battery-0",
            "battery-1",
            "battery-2",
            "battery-3",
            "battery-4",
            "battery-empty",
            "battery-full",
            "battery-half",
            "battery-quarter",
            "battery-three-quarters",
            "black-tie",
            "calendar-check-o",
            "calendar-minus-o",
            "calendar-plus-o",
            "calendar-times-o",
            "cc-diners-club",
            "cc-jcb",
            "chrome",
            "clone",
            "commenting",
            "commenting-o",
            "contao",
            "creative-commons",
            "expeditedssl",
            "firefox",
            "fonticons",
            "genderless",
            "get-pocket",
            "gg",
            "gg-circle",
            "hand-grab-o",
            "hand-lizard-o",
            "hand-paper-o",
            "hand-peace-o",
            "hand-pointer-o",
            "hand-rock-o",
            "hand-scissors-o",
            "hand-spock-o",
            "hand-stop-o",
            "hourglass",
            "hourglass-1",
            "hourglass-2",
            "hourglass-3",
            "hourglass-end",
            "hourglass-half",
            "hourglass-o",
            "hourglass-start",
            "houzz",
            "i-cursor",
            "industry",
            "internet-explorer",
            "map",
            "map-o",
            "map-pin",
            "map-signs",
            "mouse-pointer",
            "object-group",
            "object-ungroup",
            "odnoklassniki",
            "odnoklassniki-square",
            "opencart",
            "opera",
            "optin-monster",
            "registered",
            "safari",
            "sticky-note",
            "sticky-note-o",
            "television",
            "trademark",
            "tripadvisor",
            "tv",
            "vimeo",
            "wikipedia-w",
            "y-combinator",
            "yc",
            "adjust",
            "anchor",
            "archive",
            "area-chart",
            "arrows",
            "arrows-h",
            "arrows-v",
            "asterisk",
            "at",
            "automobile",
            "balance-scale",
            "ban",
            "bank",
            "bar-chart",
            "bar-chart-o",
            "barcode",
            "bars",
            "battery-0",
            "battery-1",
            "battery-2",
            "battery-3",
            "battery-4",
            "battery-empty",
            "battery-full",
            "battery-half",
            "battery-quarter",
            "battery-three-quarters",
            "bed",
            "beer",
            "bell",
            "bell-o",
            "bell-slash",
            "bell-slash-o",
            "bicycle",
            "binoculars",
            "birthday-cake",
            "bolt",
            "bomb",
            "book",
            "bookmark",
            "bookmark-o",
            "briefcase",
            "bug",
            "building",
            "building-o",
            "bullhorn",
            "bullseye",
            "bus",
            "cab",
            "calculator",
            "calendar",
            "calendar-check-o",
            "calendar-minus-o",
            "calendar-o",
            "calendar-plus-o",
            "calendar-times-o",
            "camera",
            "camera-retro",
            "car",
            "caret-square-o-down",
            "caret-square-o-left",
            "caret-square-o-right",
            "caret-square-o-up",
            "cart-arrow-down",
            "cart-plus",
            "cc",
            "certificate",
            "check",
            "check-circle",
            "check-circle-o",
            "check-square",
            "check-square-o",
            "child",
            "circle",
            "circle-o",
            "circle-o-notch",
            "circle-thin",
            "clock-o",
            "clone",
            "close",
            "cloud",
            "cloud-download",
            "cloud-upload",
            "code",
            "code-fork",
            "coffee",
            "cog",
            "cogs",
            "comment",
            "comment-o",
            "commenting",
            "commenting-o",
            "comments",
            "comments-o",
            "compass",
            "copyright",
            "creative-commons",
            "credit-card",
            "crop",
            "crosshairs",
            "cube",
            "cubes",
            "cutlery",
            "dashboard",
            "database",
            "desktop",
            "diamond",
            "dot-circle-o",
            "download",
            "edit",
            "ellipsis-h",
            "ellipsis-v",
            "envelope",
            "envelope-o",
            "envelope-square",
            "eraser",
            "exchange",
            "exclamation",
            "exclamation-circle",
            "exclamation-triangle",
            "external-link",
            "external-link-square",
            "eye",
            "eye-slash",
            "eyedropper",
            "fax",
            "feed",
            "female",
            "fighter-jet",
            "file-archive-o",
            "file-audio-o",
            "file-code-o",
            "file-excel-o",
            "file-image-o",
            "file-movie-o",
            "file-pdf-o",
            "file-photo-o",
            "file-picture-o",
            "file-powerpoint-o",
            "file-sound-o",
            "file-video-o",
            "file-word-o",
            "file-zip-o",
            "film",
            "filter",
            "fire",
            "fire-extinguisher",
            "flag",
            "flag-checkered",
            "flag-o",
            "flash",
            "flask",
            "folder",
            "folder-o",
            "folder-open",
            "folder-open-o",
            "frown-o",
            "futbol-o",
            "gamepad",
            "gavel",
            "gear",
            "gears",
            "gift",
            "glass",
            "globe",
            "graduation-cap",
            "group",
            "hand-grab-o",
            "hand-lizard-o",
            "hand-paper-o",
            "hand-peace-o",
            "hand-pointer-o",
            "hand-rock-o",
            "hand-scissors-o",
            "hand-spock-o",
            "hand-stop-o",
            "hdd-o",
            "headphones",
            "heart",
            "heart-o",
            "heartbeat",
            "history",
            "home",
            "hotel",
            "hourglass",
            "hourglass-1",
            "hourglass-2",
            "hourglass-3",
            "hourglass-end",
            "hourglass-half",
            "hourglass-o",
            "hourglass-start",
            "i-cursor",
            "image",
            "inbox",
            "industry",
            "info",
            "info-circle",
            "institution",
            "key",
            "keyboard-o",
            "language",
            "laptop",
            "leaf",
            "legal",
            "lemon-o",
            "level-down",
            "level-up",
            "life-bouy",
            "life-buoy",
            "life-ring",
            "life-saver",
            "lightbulb-o",
            "line-chart",
            "location-arrow",
            "lock",
            "magic",
            "magnet",
            "mail-forward",
            "mail-reply",
            "mail-reply-all",
            "male",
            "map",
            "map-marker",
            "map-o",
            "map-pin",
            "map-signs",
            "meh-o",
            "microphone",
            "microphone-slash",
            "minus",
            "minus-circle",
            "minus-square",
            "minus-square-o",
            "mobile",
            "mobile-phone",
            "money",
            "moon-o",
            "mortar-board",
            "motorcycle",
            "mouse-pointer",
            "music",
            "navicon",
            "newspaper-o",
            "object-group",
            "object-ungroup",
            "paint-brush",
            "paper-plane",
            "paper-plane-o",
            "paw",
            "pencil",
            "pencil-square",
            "pencil-square-o",
            "phone",
            "phone-square",
            "photo",
            "picture-o",
            "pie-chart",
            "plane",
            "plug",
            "plus",
            "plus-circle",
            "plus-square",
            "plus-square-o",
            "power-off",
            "print",
            "puzzle-piece",
            "qrcode",
            "question",
            "question-circle",
            "quote-left",
            "quote-right",
            "random",
            "recycle",
            "refresh",
            "registered",
            "remove",
            "reorder",
            "reply",
            "reply-all",
            "retweet",
            "road",
            "rocket",
            "rss",
            "rss-square",
            "search",
            "search-minus",
            "search-plus",
            "send",
            "send-o",
            "server",
            "share",
            "share-alt",
            "share-alt-square",
            "share-square",
            "share-square-o",
            "shield",
            "ship",
            "shopping-cart",
            "sign-in",
            "sign-out",
            "signal",
            "sitemap",
            "sliders",
            "smile-o",
            "soccer-ball-o",
            "sort",
            "sort-alpha-asc",
            "sort-alpha-desc",
            "sort-amount-asc",
            "sort-amount-desc",
            "sort-asc",
            "sort-desc",
            "sort-down",
            "sort-numeric-asc",
            "sort-numeric-desc",
            "sort-up",
            "space-shuttle",
            "spinner",
            "spoon",
            "square",
            "square-o",
            "star",
            "star-half",
            "star-half-empty",
            "star-half-full",
            "star-half-o",
            "star-o",
            "sticky-note",
            "sticky-note-o",
            "street-view",
            "suitcase",
            "sun-o",
            "support",
            "tablet",
            "tachometer",
            "tag",
            "tags",
            "tasks",
            "taxi",
            "television",
            "terminal",
            "thumb-tack",
            "thumbs-down",
            "thumbs-o-down",
            "thumbs-o-up",
            "thumbs-up",
            "ticket",
            "times",
            "times-circle",
            "times-circle-o",
            "tint",
            "toggle-down",
            "toggle-left",
            "toggle-off",
            "toggle-on",
            "toggle-right",
            "toggle-up",
            "trademark",
            "trash",
            "trash-o",
            "tree",
            "trophy",
            "truck",
            "tty",
            "tv",
            "umbrella",
            "university",
            "unlock",
            "unlock-alt",
            "unsorted",
            "upload",
            "user",
            "user-plus",
            "user-secret",
            "user-times",
            "users",
            "video-camera",
            "volume-down",
            "volume-off",
            "volume-up",
            "warning",
            "wheelchair",
            "wifi",
            "wrench"
        );
    
}
function template1_main_menu($menu_id, $parent = 0,$shareddata,$isparentzero = true,$isundermegamenu = false, $level = 0, $previousparent = 0){
  $menuitems = DB::table('menu_items')->where("menu_id",$menu_id)->orderBy('order')->get();
  $menuitems = json_decode(json_encode($menuitems), true);
  $menu_items = DB::table('menu_items')->where('menu_id',$menu_id)->where('parent',$parent)->where('language_id',$shareddata['currentlanguage'])->orderBy('order')->get();
  $haschild = DB::table('menu_items')->where('parent',$parent)->where('language_id',$shareddata['currentlanguage'])->count();
  $ddtoggelattr = "";
  $ddtoggelclass = "";
  if(count($menu_items) > 0)
  {
    if($isparentzero)
    {
        $addsearch = true;
        echo '<ul class="nav navbar-nav">';
    }else{
        $addsearch = false;
        echo '<ul class="dropdown-menu">';
    }
      $i = 0;
      $j = 0;
      foreach ($menu_items as $menuitem) {
          $haschild = 0;
          if($parent == $previousparent)
          {
            $i++;
            $j = $i;
          }

          if($j == $i && $menuitem->parent != 0)
          {
            $level++; 
          }

          if($menuitem->parent == 0){
            if($menuitem->is_megamenu == 'Yes')
            {
                $isundermegamenu = true;
                if (Request::is('*'.$menuitem->url)){
                  echo '<li class="dropdown active">';
                }else{
                  echo '<li class="dropdown active">';
                }
            }else{
                $isundermegamenu = false;
                if (Request::is('*'.$menuitem->url)){
                  echo '<li class="dropdown active">';
                }else{
                  echo '<li class="dropdown">';
                }
            }
          }else{
            if (Request::is('*'.$menuitem->url)){
              echo '<li class="active">';
            }else{
              echo '<li class="">';
            }
          }
          if($isundermegamenu && $menuitem->parent != 0)
          {
            if($level == 1)
            {
              $addarrowbefore = '';
            }else{
              $addarrowbefore = '<i class="fa fa-caret-right" aria-hidden="true"></i>';
            }
          }else{
              $addarrowbefore = '';
          }
          $haschild = DB::table('menu_items')->where('parent',$menuitem->glue)->where('language_id',$shareddata['currentlanguage'])->count();
          if($haschild)
          {
              $ddtoggelattr = 'data-toggle="dropdown"';
              $ddtoggelclass = 'dropdown-toggle';
              if($menuitem->parent == 0)
              {

                  $addarrowafter = ' <i class="fa fa-caret-down"></i>';
              }else{
                if(!$isundermegamenu)
                {
                    $addarrowafter = ' <i class="fa fa-caret-right" aria-hidden="true"></i>';
                }else{
                    $addarrowafter = '';
                }
              }
          }else{
              $addarrowafter = '';
          }
          if($menuitem->type == "custom"){
            echo '<a '.$ddtoggelattr.' class="'.$ddtoggelclass.' level level_'.$level.'" href="'.$menuitem->url.'">'.$addarrowbefore.$menuitem->link_text.$addarrowafter.'</a>';
          }else{
            echo '<a '.$ddtoggelattr.' class="'.$ddtoggelclass.' level level_'.$level.'" href="'.permalink($shareddata['currentlanguagecode'].$menuitem->url).'">'.$addarrowbefore.$menuitem->link_text.$addarrowafter.'</a>';
          }
          $isparentzero = false;
          template1_main_menu($menu_id, $menuitem->glue,$shareddata,$isparentzero,$isundermegamenu,$level, $parent);
          echo '</li>';
          $j++;
      }
      // if($addsearch)
      // {
      //   echo '<li class="search-icon"><a href="javascript:void(0);" class="header-btn-search"><i class="fa fa-search" aria-hidden="true"></i></a></li>';
      // }
      echo '</ul>';
  } 
}
function footer_menu($menu_id, $parent = 0,$shareddata,$isparentzero = true,$isundermegamenu = false, $level = 0, $previousparent = 0){
  $menuitems = DB::table('menu_items')->where("menu_id",$menu_id)->orderBy('order')->get();
  $menuitems = json_decode(json_encode($menuitems), true);
  $menu_items = DB::table('menu_items')->where('menu_id',$menu_id)->where('parent',$parent)->where('language_id',$shareddata['currentlanguage'])->orderBy('order')->get();
  $haschild = DB::table('menu_items')->where('parent',$parent)->where('language_id',$shareddata['currentlanguage'])->count();
  if(count($menu_items) > 0)
  {
    if($isparentzero)
    {
        $addsearch = true;
        echo '<ul class="footer-link">';
    }else{
        $addsearch = false;
        echo '<ul class="footer-link">';
    }
      $i = 0;
      $j = 0;
      foreach ($menu_items as $menuitem) {
          $haschild = 0;
          if($parent == $previousparent)
          {
            $i++;
            $j = $i;
          }

          if($j == $i && $menuitem->parent != 0)
          {
            $level++; 
          }

          if($menuitem->parent == 0){
            if($menuitem->is_megamenu == 'Yes')
            {
                $isundermegamenu = true;
                if (Request::is('*'.$menuitem->url)){
                  echo '<li class="dropdown active">';
                }else{
                  echo '<li class="dropdown active">';
                }
            }else{
                $isundermegamenu = false;
                if (Request::is('*'.$menuitem->url)){
                  echo '<li class="dropdown active">';
                }else{
                  echo '<li class="dropdown">';
                }
            }
          }else{
            if (Request::is('*'.$menuitem->url)){
              echo '<li class="active">';
            }else{
              echo '<li class="">';
            }
          }
          if($isundermegamenu && $menuitem->parent != 0)
          {
            if($level == 1)
            {
              $addarrowbefore = '';
            }else{
              $addarrowbefore = '<i class="fa fa-caret-right" aria-hidden="true"></i>';
            }
          }else{
              $addarrowbefore = '';
          }
          $haschild = DB::table('menu_items')->where('parent',$menuitem->glue)->where('language_id',$shareddata['currentlanguage'])->count();
          if($haschild)
          {
              if($menuitem->parent == 0)
              {
                  $addarrowafter = ' <i class="fa fa-caret-down"></i>';
              }else{
                if(!$isundermegamenu)
                {
                    $addarrowafter = ' <i class="fa fa-caret-right" aria-hidden="true"></i>';
                }else{
                    $addarrowafter = '';
                }
              }
          }else{
              $addarrowafter = '';
          }
          if($menuitem->type == "custom"){
            echo '<a class="level level_'.$level.'" href="'.$menuitem->url.'">'.$addarrowbefore.$menuitem->link_text.$addarrowafter.'</a>';
          }else{
            echo '<a class="level level_'.$level.'" href="'.permalink($shareddata['currentlanguagecode'].$menuitem->url).'">'.$addarrowbefore.$menuitem->link_text.$addarrowafter.'</a>';
          }
          $isparentzero = false;
          template1_main_menu($menu_id, $menuitem->glue,$shareddata,$isparentzero,$isundermegamenu,$level, $parent);
          echo '</li>';
          $j++;
      }
      // if($addsearch)
      // {
      //   echo '<li class="search-icon"><a href="javascript:void(0);" class="header-btn-search"><i class="fa fa-search" aria-hidden="true"></i></a></li>';
      // }
      echo '</ul>';
  } 
}
function template1_page_left_menu($menu_id, $parent = 0, $shareddata){
  $menuitems = DB::table('menu_items')->where("menu_id",$menu_id)->orderBy('order')->get();
  $menuitems = json_decode(json_encode($menuitems), true);
  $menu_items = DB::table('menu_items')->where('menu_id',$menu_id)->where('parent',$parent)->where('language_id',$shareddata['currentlanguage'])->orderBy('order')->get();
  $currenturl = Request::url();
  if(count($menu_items) > 0)
  {
    echo '<ul class="sidenav panel-group" id="abc" role="tablist" aria-multiselectable="true">';
      foreach ($menu_items as $menuitem) {
          $i = 0;
          // echo $currenturl ." == ". $menuitem->url;
          // if($currenturl == $menuitem->url){
          if (Request::is('*'.$menuitem->url)){
            echo '<li class="active">';
          }else{
            echo '<li>';
          }
          if($menuitem->type == "custom"){
            echo '<a class="collapsed" role="button" data-toggle="collapse" data-parent="#abc" aria-expanded="false" aria-controls="collapseTwo" href="'.$menuitem->url.'">'.$menuitem->link_text.'</a>';
          }else{
            echo '<a href="'.permalink($shareddata['currentlanguagecode'].$menuitem->url).'">'.$menuitem->link_text.'</a>';
          }
          
            template1_main_menu($menu_id, $menuitem->glue,$shareddata);
          echo '</li>';
          $i++;
      }
      echo '</ul>';
  } 
}

function contentblock($blockname = '', $language_id = 1)
{
  if($blockname == '')
  {
    echo '';
  }else{
    $contentblock = DB::table('content_blocks')->where('blockname',$blockname)->where('language_id',$language_id)->where('status','Active')->first();
    if($contentblock)
    {
      echo $contentblock->content;
    }
  }
}
function subhidetext($text = '')
{
  $strlen = strlen($text);
  $hidelen = round(($strlen*30)/100);
  $finaltext = '';
  for ($i=0; $i < $strlen ; $i++) 
  { 
    if($i < $strlen - $hidelen)
    {
      $finaltext .= "*";
    }else{
      $finaltext .= $text[$i];
    }
  }
  echo $finaltext;
}
function permalink($target = "")
{
  if($target == "")
  {
    return url($target);
  }
  $sluginfo = DB::table('slugs')->where('target',$target)->first();
  if($sluginfo)
  {
    return url($sluginfo->slug);
  }else{
    return url($target);
  }
}