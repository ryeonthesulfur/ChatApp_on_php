+ # chat-app テーブル設計
 
+ ### users

+| カラム名                 　| 型       | NULL | Key | 備考                 |
+| ------------------------ | -------- | ---- | --- | -------------------- |
+| id                       | bigint   | NO   | PK  | AUTO_INCREMENT       |
+| name                     | string   | NO   |     |                      |
+| email                    | string   | NO   |     | UNIQUE               |
+| password                 | string   | NO   |     |                      |
 
アソシエーション
hasMany: rooms (through room_users)
hasMany: messages 



+ ### rooms
 
+| カラム名   　| 型       | NULL | Key | 備考           |
+| ---------- | -------- | ---- | --- | -------------- |
+| id         | bigint   | NO   | PK  | AUTO_INCREMENT |
+| name       | string   | NO   |     |                |

アソシエーション
hasMany: users (through room_users)
hasMany: messages 



+ ### room_users（中間テーブル）
 
+| カラム名   　| 型       | NULL | Key | 備考           |
+| ---------- | -------- | ---- | --- | -------------- |
+| id         | bigint   | NO   | PK  | AUTO_INCREMENT |
+| room_id    | bigint   | NO   | FK  | rooms.id       |
+| user_id    | bigint   | NO   | FK  | users.id       |

 アソシエーション
 hasMany: rooms
 hasMany: users

 

+ ### messages

+| カラム名   　| 型       | NULL | Key | 備考           |
+| ---------- | -------- | ---- | --- | -------------- |
+| id         | bigint   | NO   | PK  | AUTO_INCREMENT |
+| content    | text     | YES  |     |                |
+| image_path | string   | YES  |     | 画像ファイルのパス |
+| user_id    | bigint   | NO   | FK  | users.id       |
+| room_id    | bigint   | NO   | FK  | rooms.id       |

 アソシエーション
 hasMany: users
 hasMany: rooms




 画像ファイルは storage/app/public に保存し、image_path にそのパスを格納します。


 リレーション図
 
 users ──< room_users >── rooms
 users ──< messages >── rooms
