**Genel Özet ve Developer Task'larını Nasıl Görebiliriz**
`<url>/tasks_information`  adresine get isteği atmanız koşulunda detaylı bilgiyi görebilirsiniz.

___
**Hatırlatma Bölümü**
Lütfen veritabanı bağlantılarınızı yaptıktan sonra, migartion'ları ve fixture'ı çalıştırmayı unutmayınız.

**Komutlar**
* Uzak Sunucudan Task'ları çekmek için aşağıdaki konsol komutu çalıştırılmalıdır.
`php bin/console fetch:external [options]`
```
Options:
-c, --clear Veritabanından Tüm Taskları siler
```

* Veritabanındaki tüm taskları optimize şekilde geliştiricilere aktarmak için aşağıdaki komutu çalıştırınız.
`php bin/console calculate:assigned`
