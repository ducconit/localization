## Laravel Localization

*Coded by Trung đức*

### Cài đặt

`composer require dnt/localization`

### Xóa

`composer remove dnt/localization`

### Cách dùng

Đặt các router của bạn vào trong scope
`Route::localization()`

Ví dụ:

```php
// routes/web.php
use Illuminate\Support\Facades\Route;

Route::localization(function(){
    Route::get('/',function(){
        return view('welcome');
    })
})
```

Phương thức này sẽ tự động chuyển ngôn ngữ cho dự án

Với kiểu route trên nó sẽ tạo ra các uri tương ứng với ngôn ngữ được hỗ trợ:

như ví dụ trên:

```
/
/en
/vi
```

- Bạn có thể gọi route với các định danh là các locale bạn đã khai báo trong config

```php
route('index');// ngôn ngữ hiện tại
route('vi.index');// ngôn ngữ tiếng việt
route('en.index');// ngôn ngữ tiếng anh
```

- Package này hỗ trợ sẵn cho bạn 1 route chuyển đổi ngôn ngữ mặc định:
- Đầu tiên hãy gán đoạn mã sau vào routes/web.php
```php 
Route::locale();
```
```php 
route('localization::changeLocale');
uri (GET): /change-locale/{locale}
// {locale} có thể thay thế bằng cách truyền param (ajax, axios)
vd:
$.ajax('{{ route('localization::changeLocale') }}',{
    data: {
        locale:'vi'
    }
}) 
hoặc
axios.get('{{ route('localization::changeLocale') }}',{
    params: {
      locale:'en'
    }
  });
```

<img src="/art/example-route.png">