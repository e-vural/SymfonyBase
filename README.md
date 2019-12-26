Symfony Base
============

Amaç her seferinde symfony peojesi oluşturmadan tüm ihtiyacımız olan ortamı indirip hemen kodlamaya başlamak

İndirdikten sonra .gitignore içinde en altta bulunan  kısımları yorum olmaktan çıkarıp aktifleştiriniz.


Ana Hatlarıyla Dosya yapısı
============

## 1 . app/config Ek Dosyalar


`constants.yml`
===============
`Tüm sabit parametrelerin tutulduğu dosya. Controller içinden getParameters() olarak çekilecek herşey`

`maintenance.yml`
===============

`Sistemi tümüyle bakıma almak için kullanılır. izin verileecek parametrelerde içerisinde ayarlanabilir. 'src/Project/Utils/Core/Listeners/EventListener.php' içerisinde kullanılır`


`monolog.yml`
===============

`monolog bundle aktifleştirmek içindir. sistede oluşan hataları bize mail atmak için. Şuan tam olarak aktif değil.`
