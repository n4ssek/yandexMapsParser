<?php

if(isset($_POST['submit'])){

  $text_id = trim($_POST['text_id']);
  $res_count = trim($_POST['res_count']);
  $cord_left = trim($_POST['cord_left']);
  $cord_right = trim($_POST['cord_right']);

    $contents = file_get_contents("https://search-maps.yandex.ru/v1/?text=$text_id&type=biz&lang=ru_RU&results=$res_count&bbox=$cord_left~$cord_right&apikey=033e03d2-4ee2-4469-86f9-c7a80ccd9d17");
    // Преобразуем JSON в массив
    $members = json_decode($contents, true);
    $log = fopen('log.txt','a+');



foreach ($members['features'] as $properties) {
  $org_name_arr = $properties['properties']['CompanyMetaData']['name'];
  $org_name = "$org_name_arr ; ";
  //Запись названий организаций
    fwrite($log, $org_name);
  $org_url_arr = $properties['properties']['CompanyMetaData']['url'];
  $org_url = "$org_url_arr ; ";
  //Запись сайтов организаций
    fwrite($log, $org_url);
  $org_address_arr = $properties['properties']['CompanyMetaData']['address'];
  $org_address = "$org_address_arr ; ";
  //Запись адресов
    fwrite($log, $org_address);

  $org_phones_arr = $properties['properties']['CompanyMetaData']['Phones'];
  foreach($org_phones_arr as $phones){
    //Запись телефонов
    fwrite($log, "$phones[formatted] ; ");
  }
  fwrite($log, "\n");
}


  header('Location: success.html');
}
