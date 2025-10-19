# TTRcash - Test


# Câu 1 system_settings
### a) Tự khơi tạo dự án CI4 và gắn code mẫu vào.
### b) Create migration and Model cho table system_settings
Hiện tại đã có sẳn controller `App/Admin/SystemSettingController.php`
Dựa vào nội dung bên trong code và các file liên quan để thiết kế ra. Migration tạo database, Cho bảng **system_settings**. Tạo model cho bảng **system_settings**
*cần có thêm các cột created_at, updated_at, deleted_at* để phán đoán thời gian action các tác vụ trên.
### c) Thiết kế routes thành chuẩn RestApi phục vụ cho bảng system_settings.
=> Mong muốn bỏ lên postman chạy được. bộ CRUD chuẩn restAPI.
### d) Thêm cột options, text, nullable vào bảng system_settings 

# Câu 2 email_histories
| Name          | Type      | Length | Decimals | Not Null | Virtual | Key | Comment |
|---------------|-----------|--------|----------|----------|---------|-----|---------|
| id            | bigint    | 20     |          | ✅        |         | 🔑  |         |
| code          | varchar   | 100    |          | ✅        |         |     |         |
| recipient     | varchar   | 255    |          | ✅        |         |     |         |
| cc            | varchar   | 255    |          |          |         |     |         |
| bcc           | varchar   | 255    |          |          |         |     |         |
| subject       | varchar   | 255    |          | ✅        |         |     |         |
| body          | text      |        |          | ✅        |         |     |         |
| error_message | text      |        |          |          |         |     |         |
| status        | tinyint   | 1      |          | ✅        |         |     |         |
| sent_at       | datetime  |        |          |          |         |     |         |
| resent_times  | int       | 10     |          | ✅        |         |     |         |
| deleted_at    | datetime  |        |          |          |         |     |         |
| updated_at    | datetime  |        |          |          |         |     |         |
| created_at    | datetime  |        |          |          |         |     |         |

### a) Dựa vào bảng thiết kế csdl trên tạo lại 1 bộ CRUD theo chuẩn RestAPI same same câu 1. và update nó lên postman chạy thử.
### b) Cập nhật cột resent_times lại thành int: 2 ký tự.

# Câu 3 chuẩn bị câu lệnh cần thiết để chạy dự án cũng như gửi collection postman liên quan.
